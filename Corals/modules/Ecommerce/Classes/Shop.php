<?php

namespace Corals\Modules\Ecommerce\Classes;


use Corals\Foundation\Search\Search;
use Corals\Modules\Ecommerce\Models\Attribute;
use Corals\Modules\Ecommerce\Models\Brand;
use Corals\Modules\Ecommerce\Models\Category;
use Corals\Modules\Ecommerce\Models\OrderItem;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Settings\Facades\Settings;
use Illuminate\Http\Request;
use Corals\Modules\Ecommerce\Facades\Ecommerce as EcommerceFacade;

class Shop
{
    public $page_limit;

    public function __construct()
    {
        $this->page_limit = Settings::get('ecommerce_appearance_page_limit', 15);
    }

    public function getFeaturedProducts()
    {
        $products = Product::active()->has('activeSKU', '>=', 1)->featured()->get();

        return $products;
    }

    public function getNewProducts($take = 4)
    {
        $products = Product::active()->orderBy('created_at', 'DESC')->take($take)->get();

        return $products;
    }

    protected function productsPublicBaseQuery()
    {
        return Product::active()
            ->join('ecommerce_sku', 'ecommerce_sku.product_id', '=', 'ecommerce_products.id')
            ->where('ecommerce_sku.status', 'active')
            ->groupBy('ecommerce_sku.product_id', 'ecommerce_products.id');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProducts(Request $request)
    {
        $products = $this->productsPublicBaseQuery();

        foreach ($request->all() as $filter => $value) {
            $filterMethod = $filter . 'QueryBuilderFilter';
            if (method_exists($this, $filterMethod) && !empty($value)) {
                $products = $this->{$filterMethod}($products, $value);
            }
        }

        $products = $products->addSelect('ecommerce_products.*')->paginate($this->page_limit);

        return $products;
    }

    /**
     * @param Request|null $request
     * @return mixed
     */
    public function getAllActiveProducts(Request $request = null)
    {
        $products = $this->productsPublicBaseQuery();

        return $products->get();
    }

    protected function sortQueryBuilderFilter($products, $sortOption)
    {
        switch ($sortOption) {
            case 'popular':
                break;
            case 'low_high_price':
                $products = $products->addSelect(\DB::raw('min(ecommerce_sku.regular_price) as sku_price'))->orderBy('sku_price', 'asc');
                break;
            case 'high_low_price':
                $products = $products->addSelect(\DB::raw('max(ecommerce_sku.regular_price) as sku_price'))->orderBy('sku_price', 'desc');
                break;
            case 'average_rating':
                $products = $products->leftJoin('utility_ratings', 'reviewrateable_id', '=', 'ecommerce_products.id')
                    ->where('utility_ratings.reviewrateable_type', Product::class)
                    ->orWhereNull('utility_ratings.id')
                    ->addSelect(\DB::raw('ROUND(AVG(rating), 2) as averageReviewRateable'))->orderBy('averageReviewRateable', 'desc');
                break;
            case 'a_z_order':
                $products = $products->orderBy('ecommerce_products.name', 'asc');
                break;
            case 'z_a_order':
                $products = $products->orderBy('ecommerce_products.name', 'desc');
                break;
        }
        return $products;
    }

    protected function searchQueryBuilderFilter($products, $search_term)
    {
        $search = new Search();

        $config = [
            'title_weight' => \Settings::get('ecommerce_search_title_weight'),
            'content_weight' => \Settings::get('ecommerce_search_content_weight'),
            'enable_wildcards' => \Settings::get('ecommerce_search_enable_wildcards')
        ];

        $products = $search->AddSearchPart($products, $search_term, Product::class, $config);

        return $products;
    }

    private function attributesColumnMapping()
    {
        $attributes = Attribute::where('use_as_filter', true)->get();

        $attributesColumnMapping = [];

        foreach ($attributes as $attribute) {
            switch ($attribute->type) {
                case 'checkbox':
                case 'text':
                case 'date':
                    $attributesColumnMapping[$attribute->id]['column'] = 'string_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = 'like';
                    break;
                case 'textarea':
                    $attributesColumnMapping[$attribute->id]['column'] = 'text_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = 'like';
                    break;
                case 'number':
                case 'select':
                case 'multi_values':
                case 'radio':
                    $attributesColumnMapping[$attribute->id]['column'] = 'number_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = '=';
                    break;
                default:
                    $attributesColumnMapping[$attribute->id]['column'] = 'string_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = '=';
            }
        }

        return $attributesColumnMapping;
    }

    protected function optionsQueryBuilderFilter($products, $attributes)
    {
        $attributesColumnMapping = $this->attributesColumnMapping();

        $attributes = array_filter($attributes, function ($value) {
            return !empty($value);
        });

        if (empty($attributes)) {
            return $products;
        }

        foreach ($attributes as $key => $value) {
            $products = $products->join("ecommerce_sku_options as attribute_$key", "attribute_$key.sku_id", '=', 'ecommerce_sku.id');

            $value = isset($attributesColumnMapping[$key]['operation']) && $attributesColumnMapping[$key]['operation'] == 'like' ? '%' . $value . '%' : $value;
            if (is_array($value)) {
                $products = $products->where("attribute_$key." . $attributesColumnMapping[$key]['column'] ?? 'string_value', $value);
            } else {
                $products = $products->where("attribute_$key." . $attributesColumnMapping[$key]['column'] ?? 'string_value', $attributesColumnMapping[$key]['operation'] ?? '=', $value);
            }
        }

        return $products;
    }

    protected function priceQueryBuilderFilter($products, $price)
    {
        if (!is_array($price)) {
            return $products;
        }

        $minPrice = array_get($price, 'min', 0);
        $maxPrice = array_get($price, 'max', 999999);

        if ($this->getSKUMinPrice() != $minPrice || $this->getSKUMaxPrice() != $maxPrice) {
            $products = $products->whereBetween('ecommerce_sku.regular_price', [$minPrice, $maxPrice]);
        }

        return $products;
    }

    protected function categoryQueryBuilderFilter($products, $category, $status = 'active')
    {
        /**
         * check if category is array or a single value
         */
        $queryMethod = 'where';

        if (is_array($category)) {
            $queryMethod = 'whereIn';
        }

        $orQueryMethod = 'or' . ucfirst($queryMethod);

        /**
         * get the related categories
         */
        $categories = Category::{$queryMethod}('ecommerce_categories.id', $category)
            ->orWhere(function ($parent) use ($queryMethod, $category) {
                $parent->{$queryMethod}('ecommerce_categories.parent_id', $category)
                    ->where('ecommerce_categories.parent_id', '<>', 0);
            })->{$orQueryMethod}('ecommerce_categories.slug', $category)->pluck('id')->toArray();

        /**
         * add categories query to products query
         */
        $products = $products->join('ecommerce_category_product', 'ecommerce_category_product.product_id', 'ecommerce_products.id')
            ->join('ecommerce_categories', 'ecommerce_category_product.category_id', 'ecommerce_categories.id')
            ->where(function ($query) use ($categories) {
                $query->whereIn('ecommerce_categories.id', $categories)
                    ->orWhereIn('ecommerce_categories.parent_id', $categories);
            });

        if (!empty($status)) {
            $products->where('ecommerce_categories.status', $status);
        }

        return $products;
    }

    protected function brandQueryBuilderFilter($products, $brand)
    {
        $products = $products
            ->join('ecommerce_brands', 'ecommerce_brands.id', '=', 'ecommerce_products.brand_id')
            ->where(function ($query) use ($brand) {
                $queryMethod = 'where';

                if (is_array($brand)) {
                    $queryMethod = 'whereIn';
                }

                $orQueryMethod = 'or' . ucfirst($queryMethod);

                $query->{$queryMethod}('ecommerce_brands.id', $brand)
                    ->{$orQueryMethod}('ecommerce_brands.slug', $brand);
            });

        return $products;
    }

    /**
     * @param $category_id
     * @param bool $count
     * @return mixed
     */
    public function getCategoryAvailableProducts($category_id, $count = false)
    {
        $products = Product::has('activeSKU', '>=', 1)
            ->where('ecommerce_products.status', 'active');

        $products = $this->categoryQueryBuilderFilter($products, $category_id);

        if ($count) {
            $products = $products->count();
        } else {
            $products = $products->select('ecommerce_products.*')->paginate($this->page_limit);
        }

        return $products;
    }

    public function getBrandAvailableProducts($brand, $count = false)
    {
        $products = Product::has('activeSKU', '>=', 1)
            ->where('ecommerce_products.status', 'active');

        $products = $this->brandQueryBuilderFilter($products, $brand);

        if ($count) {
            $products = $products->count();
        } else {
            $products = $products->select('ecommerce_products.*')->paginate($this->page_limit);
        }

        return $products;
    }

    protected function tagQueryBuilderFilter($products, $tag, $status = 'active')
    {
        $products = $products->join('ecommerce_product_tag', 'ecommerce_product_tag.product_id', 'ecommerce_products.id')
            ->join('ecommerce_tags', 'ecommerce_product_tag.tag_id', 'ecommerce_tags.id')
            ->where(function ($query) use ($tag) {
                $queryMethod = 'where';

                if (is_array($tag)) {
                    $queryMethod = 'whereIn';
                }

                $orQueryMethod = 'or' . ucfirst($queryMethod);

                $query->{$queryMethod}('ecommerce_tags.id', $tag)
                    ->{$orQueryMethod}('ecommerce_tags.slug', $tag);
            });

        if (!empty($status)) {
            $products->where('ecommerce_tags.status', $status);
        }

        return $products;
    }

    /**
     * @param $tag_id
     * @return mixed
     */
    public function getTagAvailableProducts($tag_id)
    {
        $products = Product::has('activeSKU', '>=', 1)
            ->where('ecommerce_products.status', 'active');

        $products = $this->tagQueryBuilderFilter($products, $tag_id);

        $products = $products->select('ecommerce_products.*')
            ->paginate($this->page_limit);

        return $products;
    }

    /**
     * @param bool $root
     * @return mixed
     */
    public function getActiveCategories($root = true)
    {
        $categories = Category::active();

        if ($root) {
            $categories = $categories->whereNull('parent_id')->orWhere('parent_id', 0);
        }

        $categories = $categories->get();

//        $categories = $categories->map(function ($category, $key) {
//            $category['products_count'] = $this->getCategoryAvailableProducts($category->id, true);
//            return $category;
//        });

        return $categories;
    }

    /**
     * @return mixed
     */
    public function getActiveBrands()
    {
        $brands = Brand::active();

        $brands = $brands
            ->leftJoin('ecommerce_products', 'ecommerce_products.brand_id', '=', 'ecommerce_brands.id')
            ->select(\DB::raw('count(ecommerce_products.id) as products_count'), 'ecommerce_brands.*')
            ->groupBy('ecommerce_products.brand_id', 'ecommerce_brands.id')
            ->get();

        return $brands;
    }

    public function getFeaturedBrands()
    {
        $featuredBrands = Brand::active()->featured()->get();

        return $featuredBrands;
    }

    public function getFeaturedCategories()
    {
        $featuredCategories = Category::active()->featured()->get();

        $featuredCategories = $featuredCategories->map(function ($category, $key) {
            $category['starting_from_price'] = SKU::join('ecommerce_products', 'ecommerce_products.id', '=', 'ecommerce_sku.product_id')
                ->join('ecommerce_category_product', 'ecommerce_category_product.product_id', 'ecommerce_products.id')
                ->join('ecommerce_categories', 'ecommerce_category_product.category_id', 'ecommerce_categories.id')
                ->where('ecommerce_categories.id', $category->id)
                ->orWhere('ecommerce_categories.parent_id', $category->id)->min('regular_price');

            return $category;
        });

        return $featuredCategories;
    }

    public function getSKUMinPrice()
    {
        return SKU::min('regular_price');
    }

    public function getSKUMaxPrice()
    {
        return SKU::max('regular_price');
    }

    public function checkActiveKey($value, $compareWithKey)
    {
        if (request()->has($compareWithKey)) {
            $compareWithValue = request()->get($compareWithKey);

            if (is_array($compareWithValue)) {
                return array_search($value, $compareWithValue) !== false;
            } else {
                return $value == $compareWithValue;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getAttributesForFilters()
    {
        $attributes = Attribute::where('use_as_filter', true)->get();

        $filters = '';

        foreach ($attributes as $attribute) {
            $filters .= EcommerceFacade::renderAttribute($attribute, null, ['as_filter' => true]);
        }

        return $filters;
    }

    /**
     * @param int $take
     * @return array
     */
    public function getTopSellers($take = 3)
    {
        // Top Sellers
        $orderItems = OrderItem::select('sku_code', \DB::raw('count(*) as sku_count'))
            ->where('type', 'Product')
            ->groupBy('sku_code')
            ->orderBy('sku_count', 'desc')
            ->take($take)
            ->get();

        $products = collect([]);

        foreach ($orderItems as $orderItem) {
            if ($product = optional($orderItem->sku)->product) {
                $products->push($product);
            }
        }
        if ($products->count() == 0) {
            $products = Product::orderByRaw('RAND()')->take($take)->get();
        }
        return $products;
    }

    /**
     * @param int $take
     * @return mixed
     */
    public function getNewArrivals($take = 3)
    {
        $products = $this->productsPublicBaseQuery();

        return $products->select('ecommerce_products.*')->orderBy('ecommerce_products.created_at', 'desc')->take($take)->get();
    }

    /**
     * @param int $take
     * @return mixed
     */
    public function getBestRated($take = 3)
    {
        $products = $this->productsPublicBaseQuery();

        $products = $products->addSelect('ecommerce_products.*');

        $products = $products->leftJoin('utility_ratings', 'reviewrateable_id', '=', 'ecommerce_products.id')
            ->where('utility_ratings.reviewrateable_type', Product::class)
            ->orderBy('averageReviewRateable', 'desc')
            ->addSelect(\DB::raw('ROUND(AVG(rating), 2) as averageReviewRateable'))
            ->take($take)->get();
        if ($products->count() == 0) {
            $products = Product::orderByRaw('RAND()')->take($take)->get();
        }
        return $products;
    }
}