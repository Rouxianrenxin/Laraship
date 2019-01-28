<?php

namespace Corals\Modules\Classified\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Classified\DataTables\ProductsDataTable;
use Corals\Modules\Classified\Http\Requests\ProductReferRequest;
use Corals\Modules\Classified\Http\Requests\ProductReportRequest;
use Corals\Modules\Classified\Http\Requests\ProductRequest;
use Corals\Modules\Classified\Models\Product;
use Corals\Modules\Utility\Traits\Gallery\ModelHasGallery;
use Corals\Modules\Utility\Facades\Category\Category;

class ProductsController extends BaseController
{
    use ModelHasGallery;

    protected $excludedRequestParams = ['categories', 'options'];

    public $view_prefix = '';

    public function __construct()
    {
        $this->title = 'Classified::module.product.title';
        $this->title_singular = 'Classified::module.product.title_singular';

        $this->setVariables();

        parent::__construct();
    }

    public function setVariables()
    {
        $this->resource_url = config('classified.models.product.resource_url');
        $this->view_prefix = 'Classified::products';
    }

    /**
     * @param ProductRequest $request
     * @param ProductsDataTable $dataTable
     * @return mixed
     */
    public function index(ProductRequest $request, ProductsDataTable $dataTable)
    {
        return $dataTable->render('Classified::products.index');
    }

    /**
     * @param ProductRequest $request
     * @return $this
     */
    public function create(ProductRequest $request)
    {
        $product = new Product();

        $statusOptions = get_array_key_translation(config('classified.models.product.status_options'));

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view($this->view_prefix . '.create_edit')->with(compact('product', 'statusOptions'));
    }


    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $data['price_on_call'] = array_get($data, 'price_on_call', false);

            $data['user_id'] = user()->id;

            // to prevent add these params in the form manually
            if (array_has($this->excludedRequestParams, 'is_featured')) {
                unset($data['is_featured']);
            }

            if (array_has($this->excludedRequestParams, 'verified')) {
                unset($data['verified']);
            }

            $product = Product::query()->create($data);

            $categories = $request->get('categories', []);

            $product->categories()->sync($categories);

            $product->indexRecord();

            Category::setModelOptions($request, $product);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'store');
        }

        return redirectTo($product->getEditUrl($this->resource_url));
    }

    /**
     * @param $request
     * @param $product
     */

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ProductRequest $request, Product $product)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $product->name])]);

        $statusOptions = get_array_key_translation(config('classified.models.product.status_options'));


        return view($this->view_prefix . '.create_edit')->with(compact('product', 'statusOptions'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $data['price_on_call'] = array_get($data, 'price_on_call', false);

            if (!array_has($this->excludedRequestParams, 'is_featured')) {
                $data['is_featured'] = array_get($data, 'is_featured', false);
            }

            if (!array_has($this->excludedRequestParams, 'verified')) {
                $data['verified'] = array_get($data, 'verified', false);
            }

            $product->update($data);

            $categories = $request->get('categories', []);

            $product->categories()->sync($categories);

            $product->indexRecord();

            Category::setModelOptions($request, $product);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    public function destroy(ProductRequest $request, Product $product)
    {
        try {
            $product->clearMediaCollection($product->galleryMediaCollection);

            $product->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]), 'class' => $product->slug];
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }


}