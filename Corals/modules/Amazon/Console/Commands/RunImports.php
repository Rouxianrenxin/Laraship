<?php namespace Corals\Modules\Amazon\Console\Commands;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use Corals\Modules\Amazon\Models\Import;
use Corals\Modules\Ecommerce\Models\Brand;
use Corals\Modules\Ecommerce\Models\Category;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Modules\Ecommerce\Models\Tag;
use Corals\Modules\Payment\Common\Http\Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class RunImports extends Command
{
    protected $signature = 'import:run';
    protected $description = 'Execute Pending Imports to import products';

    public function handle()
    {
        return $this->processImports();
    }


    public function processImports()
    {

        $running_import = Import::where('status', 'in_progress')->first();
        if ($running_import) {
            $this->info("There is already running import process ");
            return false;
        }

        $import = Import::pending()->orderBy('created_at', 'asc')->first();
        if (!$import) {
            $this->info("There is no Pending imports");
            return true;
        }


        try {
            $this->info("Running Import: " . $import->title);

            $categories = Category::whereNotNull('external_id')->pluck('id', 'external_id')->toArray();
            $brands = Brand::all()->pluck('id', 'name')->toArray();
            $tags = Tag::all()->pluck('id', 'name')->toArray();

            $import->status = 'in_progress';
            $import->notes = '';
            $import->save();

            if ($import->keywords) {
                $keywords = implode(', ', $import->keywords);

            } else {
                $keywords = "";
            }
            $conf = new GenericConfiguration();
            $client = new \GuzzleHttp\Client();
            $request = new \ApaiIO\Request\GuzzleRequest($client);
            $conf
                ->setCountry(\Settings::get('amazon_api_country1', 'com'))
                ->setAccessKey(\Settings::get('amazon_api_access_key', ''))
                ->setSecretKey(\Settings::get('amazon_api_access_secret', ''))
                ->setAssociateTag(\Settings::get('amazon_api_associate_tag', ''))
                ->setRequest($request);
            $apaiIO = new ApaiIO($conf);
            $search = new Search();
            $search->setResponseGroup(array('ItemAttributes', 'Images', 'EditorialReview', 'Reviews', 'Variations', 'Offers', 'BrowseNodes'));


            $scan_pages = $import->max_result_pages ?? 1000;

            if ($keywords) {
                $search->setKeywords($keywords);

            }


            if ($import->categories->count() > 0) {

                foreach ($import->categories as $import_category) {
                    $search->setCategory($import_category->name);

                    for ($i = 1; $i <= $scan_pages; $i++) {
                        $search->setPage($i);
                        $formattedResponse = $apaiIO->runOperation($search);
                        $this->isErrorResponse($formattedResponse);

                        $formattedResponse = simplexml_load_string($formattedResponse);
                        list($categories, $brands, $tags) = $this->parseResponse($formattedResponse, $categories, $tags, $import, $brands);

                    }
                }
            } else {
                $search->setCategory('All');

                for ($i = 1; $i <= $scan_pages; $i++) {
                    $search->setPage($i);
                    $formattedResponse = $apaiIO->runOperation($search);
                    $this->isErrorResponse($formattedResponse);

                    $formattedResponse = simplexml_load_string($formattedResponse);
                    list($categories, $brands, $tags) = $this->parseResponse($formattedResponse, $categories, $tags, $import, $brands);

                }
            }
            $this->info("Finishing Import: " . $import->title);

            $import->status = 'completed';
            $import->save();
        } catch (\Exception $exception) {
            $errors = [];

            if (!empty($errors)) {
                $error = implode("\n", $errors);
            } else {
                $error = $exception->getMessage();
            }

            $this->error("Error while importing : " . $error);
            $import->notes = $exception->getMessage();
            $import->status = 'failed';
            $import->save();
            log_exception($exception, Import::class, 'import');

        }

    }

    function isErrorResponse($response)
    {
        if (isset($response['ItemSearchErrorResponse']['Error']['Code'])) {
            $errors[$response['ItemSearchResponse']['Error']['Code']] = $response['ItemSearchResponse']['Error']['Code'] . ":\n" . $response['ItemSearchResponse']['Error']['Message'];
        } elseif (isset($response['ItemSearchErrorResponse']['Errors'][0])) {
            foreach ($response['ItemSearchErrorResponse']['Error'] as $temperr) {
                $errors[$temperr['Code']] = $temperr['Code'] . ":\n" . $temperr['Message'];
            }
        } elseif (isset($response['ItemSearchResponse']['Items']['Request']['Errors']['Error'])) {
            if (!empty($response['ItemSearchResponse']['Items']['Request']['Errors']['Error'])) {
                foreach ($response['ItemSearchResponse']['Items']['Request']['Errors']['Error'] as $error) {
                    $errors[$error['Code']] = $error['Code'] . ":\n" . $error['Message'];
                }
            }
        }
        if (!empty($errors)) {
            $error_result = implode("\n", $errors);
            throw new \Exception($error_result);
        }
        if ($response == "limit") {
            throw new \Exception('Limit Reached');

        }
    }

    function parseResponse($response, $categories, $tags, $import, $brands)
    {

        foreach ($response->Items->Item as $item) {
            if ($item->Variations) {
                $title = $item->Variations->Item[0]->ItemAttributes->Title->__toString();
                $variations = $this->getItemVariation($item, $import);
                $features = [];
                foreach ($item->Variations->Item[0]->ItemAttributes->Feature as $feature) {
                    array_push($features, $feature->__toString());
                }

                $product = [
                    'title' => $title,
                    'description' => $features,
                    'variations' => $variations,
                ];
            } else {
                $title = $item->ItemAttributes->Title->__toString();
                $brand = $item->ItemAttributes->Brand->__toString();
                $asin = $item->ASIN->__toString();

                $features = [];
                foreach ($item->ItemAttributes->Feature as $feature) {
                    array_push($features, $feature->__toString());
                }
                if ($item->Offers->Offer) {
                    $price = $item->Offers->Offer->OfferListing->Price->FormattedPrice->__toString();
                } else {
                    $price = null;
                }
                $max_images = $import->image_count ? $import->image_count : 1000;
                $image_urls = $this->getItemImages($item, $max_images);
                $price = $this->getItemPrice($item);
                $reviews = $item->CustomerReviews->IFrameURL->__toString();
                $amazonUrl = $item->DetailPageURL->__toString();
                $product = [
                    'title' => $title,
                    'asin' => $asin,
                    'features' => $features,
                    'price' => $price,
                    'reviews_url' => $reviews,
                    'amazon_url' => $amazonUrl,
                    'image_urls' => $image_urls,
                    'brand' => $brand
                ];

            }

            if (isset($product['variations'])) {
                //TODO Hanlde Variable Products

            } else {

                $sku_exists = SKU::where('code', $product['asin'])->first();
                if ($sku_exists) {
                    $import_product = $sku_exists->product;
                } else {
                    $import_product = new Product();
                }

                list($brand_id, $brands) = $this->createMissingBrand($product['brand'], $brands);

                $import_product->name = $product['title'];
                $import_product->type = 'simple';
                $import_product->description = '<br>' . implode(', ', $product['features']) . '<br><br>' . $this->reviewsIframe($product['reviews_url']);
                $import_product->name = $product['title'];
                $import_product->status = 'active';

                $import_product->save();


                $import_product->brand_id = $brand_id;
                $import_product->external_url = $product['amazon_url'];
                $import_product->save();

                $import_product->clearMediaCollection('ecommerce-product-gallery');

                $sku_data = ['regular_price' => $product['price'], 'code' => $product['asin'], 'inventory' => 'infinite'];

                SKU::where('code', $product['asin'])->delete();
                $sku = $import_product->sku()->create($sku_data);

                $first = true;
                $sku_image_url = "";
                foreach ($product['image_urls'] as $image_url) {
                    if ($first) {
                        $import_product->addMediaFromUrl($image_url)->withCustomProperties(['root' => 'amazon_media_import', 'featured' => true])->toMediaCollection('ecommerce-product-gallery');
                        $sku_image_url = $image_url;
                    } else {
                        $import_product->addMediaFromUrl($image_url)->withCustomProperties(['root' => 'amazon_media_import'])->toMediaCollection('ecommerce-product-gallery');

                    }
                    $first = false;

                }
                if ($sku_image_url) {
                    //$import_product->copyFirstMediatoSKU($sku);
                    $sku->addMediaFromUrl($sku_image_url)->withCustomProperties(['root' => 'amazon_media_import'])->toMediaCollection('ecommerce-sku-image');

                }


                $import->products()->sync($import_product, false);

                $item_categories = $this->getItemCategories($item);
                if ($item_categories) {
                    list($categories, $product_categories) = $this->createMissingCategories($categories, [array_pop($item_categories)]);
                    $import_product->categories()->sync($product_categories, []);
                }

                if ($item_categories) {
                    list($tags, $product_tags) = $this->createMissingTags($tags, $item_categories);
                    $import_product->tags()->sync($product_tags, []);
                }


            }

        }
        return [$categories, $brands, $tags];
    }

    function getItemVariation($item, $import)
    {
        //
        // get variation attribute
        $VariationDimension = $item->Variations->VariationDimensions->VariationDimension;
        $varAttributeCount = count($VariationDimension);
        $variations = [];
        $parentResult['varAttributeCount'] = $varAttributeCount;
        //
        // check parent ASIN
        if ($varAttributeCount != 0) {

            //echo "<br> we have $varAttributeCount different options <br>";
            //foreach ($VariationDimension as $attribute => $val) {
            //     echo "<br>attribute: " . $val;
            //     $attributes[] = $val;
            //}

            // total items available:
            $totalItemsAvailable = $item->Variations->TotalVariations;
            $variations = [];
            //
            // different items have different ASIN
            // display their ASIN and attributes
            for ($i = 0; $i < $totalItemsAvailable; $i++) {
                $item = $item->Variations->Item[$i];
                $asinPrice = $this->getItemPrice($item);
                $asin = $item->ASIN->__toString();
                $max_images = $import->image_count ? $import->image_count : 1000;

                $image_urls = $this->getItemImages($item, $max_images);
                //
                // get attributes:
                $VariationAttribute = $item->Variations->Item[$i]->VariationAttributes;
                $attributes = [];
                // if more then one attribute, it is an array:
                if (count($varAttributeCount) > 0) {
                    // if array, iterate through them:
                    foreach ($VariationAttribute->VariationAttribute as $attr) {
                        $attributes["{$attr->Name}"] = $attr->Value;
                    }
                } else {
                    // if only one attribute, just use it:
                    $attr_name = $item->Variations->Item[$i]->VariationAttributes->VariationAttribute->Name;
                    $attr_val = $item->Variations->Item[$i]->VariationAttributes->VariationAttribute->Value;
                    $attributes["{$attr_name}"] = $attr_val;
                }
                $variation = [
                    'asin' => $asin,
                    'attributes' => $attributes,
                    'price' => $asinPrice,
                    'image_urls' => $image_urls
                ];
                $variations[] = $variation;
            }
        }
        return $variations;
    }

    function getItemImages($item, $image_count)
    {
        $imageUrls = [];
        if ($item->ImageSets->ImageSet) {
            foreach ($item->ImageSets->ImageSet as $image_set) {
                if ($image_set->HiResImage) {
                    $imageUrls[] = $image_set->HiResImage->URL->__toString();
                } else {
                    $imageUrls[] = $image_set->LargeImage->URL->__toString();
                }
                if (count($imageUrls) >= $image_count) {
                    return $imageUrls;
                }
            }
        }

        return $imageUrls;
    }

    function reviewsIframe($url)
    {
        return '<iframe style="border:none;min-height:1000px;overflow: hidden;" width="100%" height="100%" src="' . $url . '"></iframe>';
    }

    function getItemPrice($item)
    {
        $asinPrice = $item->ItemAttributes->ListPrice->Amount;
        $asinPrice = number_format(($asinPrice / 100), 2, '.', '');
        return $asinPrice;
    }

    function createMissingCategories($categories, $item_categories)
    {
        $product_categories = [];
        foreach ($item_categories as $item_category) {
            if (!array_key_exists($item_category['id'], $categories)) {
                $category = New Category();
                $category->external_id = $item_category['id'];
                $category->name = $item_category['name'];
                $category->is_featured = false;
                $category->slug = str_slug($item_category['name']);
                $category->save();
                $categories[$item_category['id']] = $category->id;
                $product_categories[] = $category->id;
            } else {
                $product_categories[] = $categories[$item_category['id']];

            }
        }

        return [$categories, $product_categories];
    }

    function createMissingTags($tags, $item_tags)
    {
        $product_tags = [];

        foreach ($item_tags as $item_tag) {
            if (!array_key_exists($item_tag['name'], $tags)) {
                $tag = New Tag();
                $tag->name = $item_tag['name'];
                $tag->slug = str_slug($item_tag['name']);
                $tag->save();
                $tags[$item_tag['name']] = $tag->id;
                $product_tags[] = $tag->id;
            } else {
                $product_tags[] = $tags[$item_tag['name']];

            }
        }
        return [$tags, $product_tags];
    }

    function createMissingBrand($brand_name, $brands)
    {

        if (!array_key_exists($brand_name, $brands)) {
            $brand = New Brand();
            $brand->name = $brand_name;
            $brand->slug = str_slug($brand_name);
            $brand->save();
            $brands[$brand_name] = $brand->id;
            return [$brand->id, $brands];
        } else {
            return [$brands[$brand_name], $brands];

        }


    }


    function getItemCategories($item)
    {
        $categories = [];
        if ($item->BrowseNodes->BrowseNode) {
            $BrowseNode = $item->BrowseNodes->BrowseNode;
            do {
                if (strstr($BrowseNode->Name->__toString(), "(")) {
                    continue;
                }
                if ($BrowseNode->IsCategoryRoot->__toString() == "1") {
                    break;
                }
                $categories[] = ['name' => $BrowseNode->Name->__toString(), 'id' => $BrowseNode->BrowseNodeId->__toString()];

            } while ($BrowseNode = $BrowseNode->Ancestors->BrowseNode);


        }

        return $categories;
    }


}
