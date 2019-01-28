<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Ecommerce\DataTables\BrandsDataTable;
use Corals\Modules\Ecommerce\Http\Requests\BrandRequest;
use Corals\Modules\Ecommerce\Models\Brand;

class BrandsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.brand.resource_url');
        $this->title = 'Ecommerce::module.brand.title';
        $this->title_singular = 'Ecommerce::module.brand.title_singular';

        parent::__construct();
    }

    /**
     * @param BrandRequest $request
     * @param BrandsDataTable $dataTable
     * @return mixed
     */
    public function index(BrandRequest $request, BrandsDataTable $dataTable)
    {
        return $dataTable->render('Ecommerce::brands.index');
    }

    /**
     * @param BrandRequest $request
     * @return $this
     */
    public function create(BrandRequest $request)
    {
        $brand = new Brand();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Ecommerce::brands.create_edit')->with(compact('brand'));
    }

    /**
     * @param BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BrandRequest $request)
    {
        try {

            $data = $request->except('thumbnail');

            $brand = Brand::create($data);

            if ($request->hasFile('thumbnail')) {
                $brand->addMedia($request->file('thumbnail'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection($brand->mediaCollectionName);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Brand::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param BrandRequest $request
     * @param Brand $brand
     * @return Brand
     */
    public function show(BrandRequest $request, Brand $brand)
    {
        return $brand;
    }

    /**
     * @param BrandRequest $request
     * @param Brand $brand
     * @return $this
     */
    public function edit(BrandRequest $request, Brand $brand)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $brand->name])]);

        return view('Ecommerce::brands.create_edit')->with(compact('brand'));
    }

    /**
     * @param BrandRequest $request
     * @param Brand $brand
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        try {


            $data = $request->except('thumbnail', 'clear');
            $data['is_featured'] = array_get($data, 'is_featured', false);

            $brand->update($data);

            if ($request->has('clear') || $request->hasFile('thumbnail')) {
                $brand->clearMediaCollection($brand->mediaCollectionName);
            }

            if ($request->hasFile('thumbnail') && !$request->has('clear')) {
                $brand->addMedia($request->file('thumbnail'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection($brand->mediaCollectionName);
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Brand::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param BrandRequest $request
     * @param Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BrandRequest $request, Brand $brand)
    {
        try {
            $brand->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Brand::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}