<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Ecommerce\Models\Product;

class ProductTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.product.resource_url');

        parent::__construct();
    }

    /**
     * @param Product $product
     * @return array
     * @throws \Throwable
     */
    public function transform(Product $product)
    {
        $actions = [];

        if ($product->status == 'deleted') {
            $actions = array_merge([
                'edit' => '',
                'delete' => ''
            ], $actions);
        }

        if ($product->sku()->count()) {
            $actions = array_merge([
                'delete' => ''
            ], $actions);
        }

        $actions = array_merge($product->getGatewayActions($this->resource_url, $product), $actions);


        $showUrl = url("{$this->resource_url}/{$product->hashed_id}");

        $actions['delete'] = [
            'href' => url($this->resource_url . '/' . $product->hashed_id),
            'label' => trans('Corals::labels.delete'),
            'data' => [
                'action' => 'delete',
                'page_action' => 'site_reload'
            ]
        ];

        if ($product->type == "variable") {
            $actions['sku'] = [
                'href' => url($this->resource_url . '/' . $product->hashed_id . '/sku'),
                'label' => trans('Ecommerce::labels.product.variations'),
                'data' => []
            ];
            $actions['sku_add'] = [
                'href' => url($this->resource_url . '/' . $product->hashed_id . '/sku/create'),
                'label' => 'Add New' . trans('Ecommerce::labels.product.variations'),
                'data' => []
            ];
        }


        $productName = $product->name;
        if ($product->is_featured) {
            $productName .= '&nbsp;<i class="fa fa-star text-warning" title="Featured"></i>';
        }
        return [
            'id' => $product->id,
            'image' => '<a href="' . $showUrl . '">' . '<img src="' . $product->image . '" class=" img-responsive" alt="Product Image" style="max-width: 50px;max-height: 50px;"/></a>',
            'name' => '<a href="' . $showUrl . '">' . $productName . '</a>',
            'plain_name' => $productName,
            'price' => $product->price,
            'type' => $product->type == "simple" ? '<i class="fa fa-spoon"></i>' : '<i class="fa fa-sitemap"></i>',
            'brand' => $product->brand ? $product->brand->name : '-',
            'caption' => $product->caption,
            'shippable' => $product->shipping['enabled'] ? '<i class="fa fa-truck"></i>' : '<i class="fa fa-times"></i>',
            'status' => formatStatusAsLabels($product->status),
            'categories' => formatArrayAsLabels($product->categories->pluck('name'), 'success', '<i class="fa fa-folder-open"></i>'),
            'tags' => generatePopover(formatArrayAsLabels($product->tags->pluck('name'), 'primary', '<i class="fa fa-tags"></i>')),
            'description' => $product->description ? generatePopover($product->description) : '-',
            'gateway_status' => $product->getGatewayStatus(),
            'global_options' => formatArrayAsLabels($product->globalOptions->pluck('label')),
            'variation_options' => formatArrayAsLabels($product->variationOptions->pluck('label'), 'info'),
            'created_at' => format_date($product->created_at),
            'updated_at' => format_date($product->updated_at),
            'action' => $this->actions($product, $actions)
        ];
    }
}