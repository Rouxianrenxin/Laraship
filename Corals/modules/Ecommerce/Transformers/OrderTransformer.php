<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Ecommerce\Models\Order;

class OrderTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.order.resource_url');

        parent::__construct();
    }

    /**
     * @param Order $order
     * @return array
     * @throws \Throwable
     */
    public function transform(Order $order)
    {
        $actions = ['edit' => '', 'delete' => ''];

        if (user()->hasPermissionTo('Ecommerce::order.update')) {
            $actions['change_status'] = [
                'icon' => 'fa fa-fw fa-edit',
                'href' => url($this->resource_url . '/' . $order->hashed_id . '/edit'),
                'label' => trans('Ecommerce::labels.order.update_order'),
                'class' => 'modal-load',
                'data' => [
                    'title' => 'Update Order'
                ]

            ];
        }

        $currency = strtoupper($order->currency);

        return [
            'status' => trans('Ecommerce::status.order.' . strtolower($order->status)),
            'order_number' => '<a href="' . url($this->resource_url . '/' . $order->hashed_id) . '">' . $order->order_number . '</a>',
            'id' => $order->id,
            'currency' => $currency,
            'amount' => currency()->format($order->amount, $currency),
            'user_id' => "<a target='_blank' href='" . url('users/' . $order->user->hashed_id) . "'> {$order->user->name}</a>",

            'created_at' => format_date($order->created_at),
            'updated_at' => format_date($order->updated_at),
            'action' => $this->actions($order, $actions)
        ];
    }
}