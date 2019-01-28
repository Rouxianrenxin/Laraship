<?php

namespace Corals\Modules\Classified\Http\Controllers;

use Corals\Modules\Classified\Http\Requests\ProductReferRequest;
use Corals\Modules\Classified\Http\Requests\ProductReportRequest;
use Corals\Modules\Classified\Models\Product;
use Corals\Modules\CMS\Traits\SEOTools;
use Corals\Foundation\Http\Controllers\PublicBaseController;
use Illuminate\Http\Request;
use Corals\Modules\Classified\Facades\Classified;

class ProductsPublicController extends PublicBaseController
{
    use SEOTools;

    public function __construct()
    {
        $this->resource_url = config('classified.models.product.resource_url');

        $this->title = 'Classified::module.product.title';
        $this->title_singular = 'Classified::module.product.title_singular';

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {

        $item = [
            'title' => 'Products',
            'meta_description' => 'Classified Products',
            'url' => url('product'),
            'type' => 'shop',
            'image' => \Settings::get('site_logo'),
            'meta_keywords' => 'product,classified,products'
        ];

        $this->setSEO((object)$item);
        $products = Classified::getProducts($request);

        $layout = $request->get('layout', 'grid');

        $sortOptions = get_array_key_translation(config('classified.models.product.sort_options'));

        return view('templates.products')->with(compact('products', 'layout', 'sortOptions'));
    }

    public function show(Request $request, $slug)
    {

        $product = Classified::productsPublicBaseQuery();

        $product = $product->where('slug', $slug)->first();

        if (!$product) {
            abort(404);
        }

        $categories = join(',', $product->activeCategories->pluck('name')->toArray());

        $tags = join(',', $product->activeTags->pluck('name')->toArray());

        $item = [
            'title' => $product->name,
            'meta_description' => str_limit(strip_tags($product->description), 500),
            'url' => $product->getShowURL(),
            'type' => 'product',
            'image' => $product->image,
            'meta_keywords' => $categories . ',' . $tags
        ];

        $this->setSEO((object)$item);

        return view('templates.product_show')->with(compact('product'));
    }

    public function report(ProductReportRequest $request, Product $product)
    {
        try {

            $name = $request->input('name');
            $email = $request->input('email');
            $report_body = $request->input('report_body');

            event('notifications.classified.product.reported', ['name' => $name, 'report_body' => $report_body, 'email' => $email, 'product' => $product]);

            $message = ['level' => 'success', 'message' => trans('Classified::labels.product.report_success', ['name' => $product->name]), 'class' => $product->slug];
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'report');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }


    public function refer(ProductReferRequest $request, Product $product)
    {
        try {

            $name = $request->input('name');
            $referrer_email = $request->input('referrer_email');
            $refer_body = $request->input('refer_body');
            $referrer_name = $request->input('referrer_name');

            \Mail::send('Classified::mails.refer',
                array(
                    'name' => $name,
                    'product' => $product,
                    'referrer_name' => $referrer_name,
                    'user_message' => $refer_body
                ), function ($message) use ($referrer_name, $referrer_email, $product) {
                    $message->to($referrer_email, $referrer_name)
                        ->subject($product->name);
                });


            $message = ['level' => 'success', 'message' => trans('Classified::labels.product.refer_success', ['name' => $product->name]), 'class' => $product->slug];
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}