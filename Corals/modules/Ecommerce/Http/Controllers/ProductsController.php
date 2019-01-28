<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Ecommerce\Classes\Ecommerce;
use Corals\Modules\Ecommerce\DataTables\ProductsDataTable;
use Corals\Modules\Ecommerce\Http\Requests\ProductRequest;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Modules\Ecommerce\Models\Tag;
use Corals\Modules\Ecommerce\Traits\DownloadableController;
use Corals\Modules\Ecommerce\Traits\EcommerceGallery;
use Corals\Modules\Utility\Http\Requests\Rating\RatingRequest;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;
use Corals\Modules\Utility\Classes\Rating\RatingManager;


class ProductsController extends BaseController
{
    use DownloadableController, EcommerceGallery;

    public $sku_attributes = ['regular_price', 'sale_price', 'code', 'inventory', 'inventory_value', 'allowed_quantity'];

    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.product.resource_url');
        $this->title = 'Ecommerce::module.product.title';
        $this->title_singular = trans('Ecommerce::module.product.title_singular');

        parent::__construct();
    }

    /**
     * @param ProductRequest $request
     * @return $this
     */
    public function index(ProductRequest $request, ProductsDataTable $dataTable)
    {
        return $dataTable->render('Ecommerce::products.index');
    }

    /**
     * @param ProductRequest $request
     * @return $this
     */
    public function create(ProductRequest $request)
    {
        $product = new Product();
        $sku = new SKU();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Ecommerce::products.create_edit')->with(compact('product', 'sku'));
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->except(array_merge(['global_options', 'variation_options', 'create_gateway_product', 'tax_classes', 'categories', 'tags', 'posts', 'private_content_pages', 'downloads_enabled', 'downloads', 'cleared_downloads', 'external'], $this->sku_attributes));

            $data = $this->setShippingData($data);

            $product = Product::create($data);

            if ($product->type == "simple") {
                $sku_data = $request->only(array_merge($this->sku_attributes, ['status']));
                $product->sku()->create($sku_data);
            }

            $product->categories()->sync($request->get('categories', []));
            $product->tax_classes()->sync($request->get('tax_classes', []));

            $attributes = [];
            foreach ($request->get('global_options', []) as $option) {
                $attributes[] = [
                    'attribute_id' => $option,
                    'sku_level' => false,
                ];
            }
            if ($product->type == "variable") {

                foreach ($request->get('variation_options', []) as $option) {
                    $attributes[] = [
                        'attribute_id' => $option,
                        'sku_level' => true,
                    ];
                }
            }
            $product->attributes()->sync($attributes);

            $tags = $this->getTags($request);

            $product->tags()->sync($tags);

            $product->posts()->sync($request->get('posts', []));


            $this->handleDownloads($request, $product);

            $product->indexRecord();

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    public function downloadFile(Request $request, $hashed_id)
    {
        if (!user()->hasPermissionTo('Ecommerce::product.update')) {
            abort(403);
        }

        $id = hashids_decode($hashed_id);

        $media = Media::findOrfail($id);

        return response()->download(storage_path($media->getUrl()));
    }

    protected function setShippingData($data)
    {
        if (!isset($data['shipping']['enabled'])) {
            $data['shipping']['enabled'] = 0;
        }

        return $data;
    }

    /**
     * @param $request
     * @return array
     */
    private function getTags($request)
    {
        $tags = [];

        $requestTags = $request->get('tags', []);

        foreach ($requestTags as $tag) {
            if (is_numeric($tag)) {
                array_push($tags, $tag);
            } else {
                try {
                    $newTag = Tag::create([
                        'name' => $tag,
                        'slug' => str_slug($tag)
                    ]);

                    array_push($tags, $newTag->id);
                } catch (\Exception $exception) {
                    continue;
                }
            }
        }

        return $tags;
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return $this
     */
    public function show(ProductRequest $request, Product $product)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $product->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $product->hashed_id . '/edit']);
        return view('Ecommerce::products.show')->with(compact('product'));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return $this
     */
    public function edit(ProductRequest $request, Product $product)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $product->name])]);
        $sku = $product->sku->first();
        if (!$sku) {
            $sku = new SKU();
        }
        return view('Ecommerce::products.create_edit')->with(compact('product', 'sku'));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->except(array_merge(['global_options', 'variation_options', 'categories', 'tags', 'tax_classes', 'downloads_enabled', 'downloads', 'cleared_downloads', 'private_content_pages', 'posts', 'external'], $this->sku_attributes));

            $data = $this->setShippingData($data);

            $data['is_featured'] = array_get($data, 'is_featured', false);

            $data['properties'] = array_get($data, 'properties', []);

            $product->update($data);

            if ($product->type == "simple") {
                $sku_data = $request->only(array_merge($this->sku_attributes, ['status']));
                if ($product->sku->first()) {
                    $product->sku->first()->update($sku_data);
                } else {
                    $product->sku()->create($sku_data);
                }
            }

            $attributes = [];
            foreach ($request->get('global_options', []) as $option) {
                $attributes[$option] = [
                    'sku_level' => false,
                ];
            }

            if ($product->type == "variable") {
                foreach ($request->get('variation_options', []) as $option) {
                    $attributes[$option] = [
                        'sku_level' => true,
                    ];
                }
            }

            $product->attributes()->sync($attributes);

            $product->categories()->sync($request->get('categories', []));

            $tags = $this->getTags($request);

            $product->posts()->sync($request->get('posts', []));

            $product->tags()->sync($tags);

            $product->tax_classes()->sync($request->get('tax_classes', []));

            $this->handleDownloads($request, $product);

            //$this->createUpdateGatewayProductSend($product);
            $product->indexRecord();

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProductRequest $request, Product $product)
    {
        try {
            $gateways = \Payments::getAvailableGateways();

            foreach ($gateways as $gateway => $gateway_title) {
                $Ecommerce = new Ecommerce($gateway);
                if (!$Ecommerce->gateway->getConfig('manage_remote_product')) {
                    continue;
                }

                $Ecommerce->deleteProduct($product);
                $product->setGatewayStatus($this->gateway->getName(), 'DELETED', null);
            }

            $product->clearMediaCollection('product-downloads');
            $product->clearMediaCollection($product->galleryMediaCollection);

            $product->delete();
            $product->unIndexRecord();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, Product::class, 'destroy');
        }

        return response()->json($message);
    }

    /**
     * @param Product $product
     * @throws \Exception
     */
    protected function createUpdateGatewayProductSend(Product $product, $gateway = null)
    {
        if ($gateway) {
            $gateways = [$gateway];
        } else {
            $gateways = \Payments::getAvailableGateways();
        }

        $exceptionMessage = '';
        foreach ($gateways as $gateway => $gateway_title) {
            try {
                $Ecommerce = new Ecommerce($gateway);


                if (!$Ecommerce->gateway->getConfig('manage_remote_product')) {
                    continue;
                }
                if ($Ecommerce->gateway->getGatewayIntegrationId($product)) {
                    $Ecommerce->updateProduct($product);
                } else {
                    $Ecommerce->createProduct($product);
                }
            } catch (\Exception $exception) {
                $exceptionMessage .= $exception->getMessage();
            }
        }
        if (!empty($exceptionMessage)) {
            throw new \Exception($exceptionMessage);
        }
    }


    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function createGatewayProduct(Request $request, Product $product)
    {
        $gateway = $request->get('gateway');
        user()->can('Ecommerce::product.create', Product::class);

        try {
            $this->createUpdateGatewayProductSend($product, $gateway);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.created', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'createGatewayProduct');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}