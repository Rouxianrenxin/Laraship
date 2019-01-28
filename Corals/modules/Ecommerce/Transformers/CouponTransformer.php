<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Ecommerce\Models\Coupon;

class CouponTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.coupon.resource_url');

        parent::__construct();
    }

    /**
     * @param Coupon $coupon
     * @return array
     * @throws \Throwable
     */
    public function transform(Coupon $coupon)
    {
        $coupon_status = $coupon->status();
        if ($coupon_status == "active") {
            $status = '<span class="label label-success">' . trans('Ecommerce::attributes.coupon.status_options.active') . '</span>';
        } else if ($coupon_status == "pending") {
            $status = '<span class="label label-info">' . trans('Ecommerce::attributes.coupon.status_options.pending') . '</span>';

        } else {
            $status = '<span class="label label-warning">' . trans('Ecommerce::attributes.coupon.status_options.expired') . '</span>';
        }

        return [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'value' => $coupon->type == "percentage" ? $coupon->value . "%" : currency()->format($coupon->value, \Payments::admin_currency_code()),
            'parent_id' => optional($coupon->parent)->name ?? '-',
            'type' => ucfirst($coupon->type),
            'start' => format_date($coupon->start),
            'status' => $status,
            'expiry' => format_date($coupon->expiry),
            'action' => $this->actions($coupon)
        ];


    }
}