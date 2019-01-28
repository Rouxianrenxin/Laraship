<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Payment\Models\Tax;

class TaxTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('payment_common.models.tax.resource_route');

        parent::__construct();
    }

    /**
     * @param Tax $tax
     * @return array
     * @throws \Throwable
     */
    public function transform(Tax $tax)
    {
        $url = route($this->resource_route, ['tax_class' => $tax->tax_class->hashed_id]);

        $hide_actions = [];


        return [
            'id' => $tax->id,
            'name' => str_limit($tax->name, 50),
            'status' => formatStatusAsLabels($tax->status),
            'priority' => $tax->priority,
            'country' => $tax->country,
            'state' => $tax->state,
            'zip' => $tax->zip,
            'compound' => $tax->compound ? '<i class="fa fa-check text-success"></i>' : '-',
            'rate' => $tax->rate . '%',
            'created_at' => format_date($tax->created_at),
            'updated_at' => format_date($tax->updated_at),
            'action' => $this->actions($tax, $hide_actions, $url)
        ];
    }
}