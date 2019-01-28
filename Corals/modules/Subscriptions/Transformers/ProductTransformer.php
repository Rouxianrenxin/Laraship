<?php

namespace Corals\Modules\Subscriptions\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Subscriptions\Models\Product;

class ProductTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('subscriptions.models.product.resource_url');

        parent::__construct();
    }

    /**
     * @param Product $product
     * @return array
     * @throws \Throwable
     */
    public function transform(Product $product)
    {
        $hide_actions = [];

        if ($product->status == 'deleted') {
            $hide_actions = array_merge([
                'edit' => '',
                'delete' => ''
            ], $hide_actions);
        }

        return [
            'id' => $product->id,
            'image' => '<a href="#">' . '<img src="' . $product->image . '" class=" img-responsive" alt="Product Image" width="50"/></a>',
            'name' => $product->name,
            'status' => formatStatusAsLabels($product->status),
            'description' => generatePopover($product->description),
            'created_at' => format_date($product->created_at),
            'updated_at' => format_date($product->updated_at),
            'short_code' => "@pricing({$product->id})",
            'action' => $this->actions($product, array_merge([
                'delete' => [

                    'href' => url($this->resource_url . '/' . $product->hashed_id),
                    'label' => trans('Corals::labels.delete'),
                    'data' => [
                        'action' => 'delete',
                        'page_action' => 'site_reload'
                    ]
                ],
                'features' => [
                    'href' => url($this->resource_url . '/' . $product->hashed_id . '/features'),
                    'label' => trans('Subscriptions::labels.plan.features'),
                    'data' => []
                ],
                'plans' => [
                    'href' => url($this->resource_url . '/' . $product->hashed_id . '/plans'),
                    'label' => trans('Subscriptions::labels.feature.plan'),
                    'data' => []
                ]
            ], $hide_actions))
        ];
    }
}