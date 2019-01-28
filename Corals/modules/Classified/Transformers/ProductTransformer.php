<?php

namespace Corals\Modules\Classified\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Classified\Models\Product;

class ProductTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('classified.models.product.resource_url');

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


        $showUrl = $product->getShowURL();

        $actions['delete'] = [
            'href' => url($this->resource_url . '/' . $product->hashed_id),
            'label' => trans('Corals::labels.delete'),
            'data' => [
                'action' => 'delete',
                'page_action' => 'site_reload'
            ]
        ];


        $productName = $product->name;

        if ($product->is_featured) {
            $productName .= '&nbsp;<i class="fa fa-star text-warning" title="Featured"></i>';
        }

        return [
            'id' => $product->id,
            'image' => '<a href="' . $showUrl . '">' . '<img src="' . $product->image . '" class=" img-responsive" alt="' . $product->name . '" style="width: auto;max-height: 60px;max-width: 100px;"/></a>',
            'name' => '<a href="' . $showUrl . '">' . $productName . '</a>',
            'plain_name' => $productName,
            'location' => $product->location->name,
            'price' => \Payments::currency($product->price),
            'caption' => $product->caption,
            'status' => formatStatusAsLabels($product->status, ['text' => trans('Classified::attributes.product.status_options.' . $product->status)]),
            'categories' => formatArrayAsLabels($product->categories->pluck('name'), 'success', '<i class="fa fa-folder-open"></i>'),
            'tags' => generatePopover(formatArrayAsLabels($product->tags->pluck('name'), 'primary', '<i class="fa fa-tags"></i>')),
            'description' => $product->description ? generatePopover($product->description) : '-',
            'options' => formatArrayAsLabels($product->options ? $product->options->pluck('label') : ''),
            'condition' => \Settings::get('classified_product_condition_options', [])[$product->condition] ?? '-',
            'created_at' => format_date($product->created_at),
            'updated_at' => format_date($product->updated_at),
            'created_by' => "<a href='" . url('users/' . $product->user->hashed_id) . "'> {$product->user->full_name}</a>",
            'action' => $this->actions($product, $actions)
        ];
    }
}