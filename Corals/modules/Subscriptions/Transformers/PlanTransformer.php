<?php

namespace Corals\Modules\Subscriptions\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Subscriptions\Models\Plan;

class PlanTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('subscriptions.models.plan.resource_route');

        parent::__construct();
    }

    /**
     * @param Plan $plan
     * @return array
     * @throws \Throwable
     */
    public function transform(Plan $plan)
    {
        $url = route($this->resource_route, ['product' => $plan->product->hashed_id]);

        $actions = [];

        if ($plan->status == 'deleted') {
            $actions = array_merge([
                'edit' => '',
                'delete' => '',
            ], $actions);
        }

        if (!$plan->free_plan) {
            $actions = array_merge($plan->getGatewayActions($url, $plan), $actions);
        }

        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'price' => $plan->price,
            'bill_frequency' => $plan->bill_frequency,
            'bill_cycle' => $plan->cycle_caption,
            'status' => formatStatusAsLabels($plan->status),
            'recommended' => $plan->recommended ? '<i class="fa fa-check text-success"></i>' : '-',
            'is_visible' => $plan->is_visible ? '<i class="fa fa-check text-success"></i>' : '-',
            'display_order' => $plan->display_order,
            'description' => generatePopover($plan->description),
            'gateway_status' => $plan->getGatewayStatus(),
            'free_plan' => $plan->free_plan ? '<i class="fa fa-check text-success"></i>' : '-',
            'created_at' => format_date($plan->created_at),
            'updated_at' => format_date($plan->updated_at),
            'action' => $this->actions($plan, $actions, $url)
        ];
    }
}