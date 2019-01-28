<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Ecommerce\DataTables\CouponsDataTable;
use Corals\Modules\Ecommerce\Http\Requests\CouponRequest;
use Corals\Modules\Ecommerce\Models\Coupon;

class CouponsController extends BaseController
{


    public function __construct()
    {


        $this->resource_url = config('ecommerce.models.coupon.resource_url');
        $this->title = 'Ecommerce::module.coupon.title';
        $this->title_singular = 'Ecommerce::module.coupon.title_singular';
        parent::__construct();
    }

    /**
     * @param CouponRequest $request
     * @param CouponsDataTable $dataTable
     * @return mixed
     */
    public function index(CouponRequest $request, CouponsDataTable $dataTable)
    {
        return $dataTable->render('Ecommerce::coupons.index');
    }

    /**
     * @param CouponRequest $request
     * @return $this
     */
    public function create(CouponRequest $request)
    {
        $coupon = new Coupon();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Ecommerce::coupons.create_edit')->with(compact('coupon'));
    }

    /**
     * @param CouponRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CouponRequest $request)
    {
        try {
            $data = $request->except('users', 'products');

            $coupon = Coupon::create($data);

            if ($request->get('users')) {

                $coupon->users()->sync($request->get('users'));
            }

            if ($request->get('products')) {
                $coupon->products()->sync($request->get('products'));
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Coupon::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return Coupon
     */
    public function show(CouponRequest $request, Coupon $coupon)
    {
        return $coupon;
    }

    /**
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return $this
     */
    public function edit(CouponRequest $request, Coupon $coupon)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $coupon->code])]);

        return view('Ecommerce::coupons.create_edit')->with(compact('coupon'));
    }

    /**
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        try {
            $data = $request->except('users', 'products');

            $coupon->update($data);

            $users = [];
            if ($request->get('users')) {
                $users = $request->get('users');
            }
            $coupon->users()->sync($users);

            $products = [];
            if ($request->get('products')) {
                $products = $request->get('products');

            }
            $coupon->products()->sync($request->get('products'));


            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Coupon::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CouponRequest $request, Coupon $coupon)
    {
        try {
            $coupon->clearMediaCollection($coupon->mediaCollectionName);
            $coupon->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Coupon::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

}