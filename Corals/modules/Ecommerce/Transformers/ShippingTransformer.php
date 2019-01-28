<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Ecommerce\Models\Shipping;

class ShippingTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.shipping.resource_url');

        parent::__construct();
    }

    /**
     * @param Shipping $shipping
     * @return array
     * @throws \Throwable
     */
    public function transform(Shipping $shipping)
    {
        $shipping_status = $shipping->status();
        if ($shipping_status == "active") {
            $status = '<span class="label label-success">' . trans('Ecommerce::attributes.shipping.status_options.active') . '</span>';
        } else if ($shipping_status == "pending") {
            $status = '<span class="label label-info">' . trans('Ecommerce::attributes.shipping.status_options.pending') . '</span>';

        } else {
            $status = '<span class="label label-warning">' . trans('Ecommerce::attributes.shipping.status_options.expired') . '</span>';
        }

        return [
            'id' => $shipping->id,
            'priority' => $shipping->priority,
            'exclusive' => $shipping->exclusive ? '<i class="fa fa-check text-success"></i>' : '-',
            'name' => $shipping->name,
            'shipping_method' => $shipping->shipping_method,
            'rate' => $shipping->rate ? currency()->format($shipping->rate, \Payments::admin_currency_code()) : '-',
            'min_order_total' => $shipping->min_order_total ? currency()->format($shipping->min_order_total, \Payments::admin_currency_code()) : '-',
            'country' => $shipping->country ?? 'All Countries',
            'action' => $this->actions($shipping)
        ];
    }
}