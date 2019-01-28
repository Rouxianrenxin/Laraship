<?php

namespace Corals\Modules\Subscriptions\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Subscriptions\DataTables\ProductsDataTable;
use Corals\Modules\Subscriptions\Http\Requests\ProductRequest;
use Corals\Modules\Subscriptions\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('subscriptions.models.product.resource_url');
        $this->title = 'Subscriptions::module.product.title';
        $this->title_singular = 'Subscriptions::module.product.title_singular';

        parent::__construct();
    }

    /**
     * @param ProductRequest $request
     * @return $this
     */
    public function index(ProductRequest $request)
    {
        $grid_items = Product::visible()->paginate();

        $grid_item_view = 'Subscriptions::products.grid_item';

        return view('Subscriptions::products.grid')->with(compact('grid_item_view', 'grid_items'));
    }

    /**
     * @param ProductRequest $request
     * @return $this
     */
    public function create(ProductRequest $request)
    {
        $product = new Product();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Subscriptions::products.create_edit')->with(compact('product'));
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->except('image');

            $product = Product::create($data);

            if ($request->hasFile('image')) {
                $this->addMedia($request, $product);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    protected function addMedia(Request $request, Product $product)
    {
        $product->addMedia($request->file('image'))
            ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
            ->toMediaCollection('product-image');
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return $this
     */
    public function show(ProductRequest $request, Product $product)
    {
        $this->setViewSharedData(['title_singular' =>  trans('Corals::labels.show_title', ['title' => $product->name])]);
        return view('Subscriptions::products.show')->with(compact('product'));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return $this
     */
    public function edit(ProductRequest $request, Product $product)
    {
        $this->isEditable($product);

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $product->name])]);

        return view('Subscriptions::products.create_edit')->with(compact('product'));
    }

    protected function isEditable(Product $product)
    {
        if ($product->status == 'deleted') {
            abort(404);
        }
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->isEditable($product);

        try {
            $data = $request->except('clear', 'image');

            $product->update($data);

            if ($request->has('clear') || $request->hasFile('image')) {
                $product->clearMediaCollection('product-image');
            }

            if ($request->hasFile('image') && !$request->has('clear')) {
                $this->addMedia($request, $product);
            }

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
            $product->features()->update(['status' => 'deleted']);
            $product->plans()->update(['status' => 'deleted']);
            $product->update(['status' => 'deleted']);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Product::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}