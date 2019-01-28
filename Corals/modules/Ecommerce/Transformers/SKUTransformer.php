<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Ecommerce\Models\SKU;

class SKUTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('ecommerce.models.sku.resource_route');

        parent::__construct();
    }

    /**
     * @param SKU $sku
     * @return array
     * @throws \Throwable
     */
    public function transform(SKU $sku)
    {
        $url = route($this->resource_route, ['product' => $sku->product->hashed_id]);

        $actions = [];

        $actions = array_merge($sku->getGatewayActions($url, $sku), $actions);
        $sku_options = [];
        $options = $sku->options ?? [];
        foreach ($options as $option) {
            $sku_options[$option->attribute->label] = $option->formatted_value;
        }

        return [
            'id' => $sku->id,
            'code' => $sku->code ?? '-',
            'image' => '<img src="' . $sku->image . '" class=" img-responsive" alt="SKU Image" style="max-height: 50px;width: auto;"/></a>',
            'price' => $sku->price,
            'inventory' => trim("{$sku->inventory}: {$sku->inventory_value}", ': '),
            'gateway_status' => $sku->getGatewayStatus(),
            'inventory_value' => $sku->inventory_value,
            'options' => \Filters::do_filter('ecommerce_sku_options', formatArrayAsLabels($sku_options, 'info', null, true), $sku),
            'dt_options' => generatePopover(formatArrayAsLabels($sku_options, 'info', null, true)),
            'status' => formatStatusAsLabels($sku->status),

            'created_at' => format_date($sku->created_at),
            'updated_at' => format_date($sku->updated_at),
            'action' => $this->actions($sku, $actions, $url)
        ];
    }
}