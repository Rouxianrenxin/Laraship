<?php

namespace Corals\Modules\Subscriptions\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Subscriptions\Models\Feature;

class FeatureTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('subscriptions.models.feature.resource_route');

        parent::__construct();
    }

    /**
     * @param Feature $feature
     * @return array
     * @throws \Throwable
     */
    public function transform(Feature $feature)
    {
        $url = route($this->resource_route, ['product' => $feature->product->hashed_id]);

        $hide_actions = [];

        if ($feature->status == 'deleted') {
            $hide_actions = array_merge([
                'edit' => '',
                'delete' => ''
            ], $hide_actions);
        }

        return [
            'id' => $feature->id,
            'display_order' => $feature->display_order,
            'name' => $feature->name,
            'caption' => $feature->caption,
            'unit' => $feature->unit,
            'status' => formatStatusAsLabels($feature->status),
            'type' => ucfirst($feature->type),
            'description' => generatePopover($feature->description, $text = '', $icon = 'fa fa-sticky-note', $placement = 'bottom', 'hover'),
            'created_at' => format_date($feature->created_at),
            'updated_at' => format_date($feature->updated_at),
            'action' => $this->actions($feature, $hide_actions, $url)
        ];
    }
}