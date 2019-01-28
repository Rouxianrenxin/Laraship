<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Payment\Models\TaxClass;

class TaxClassTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.models.tax_class.resource_url');

        parent::__construct();
    }

    /**
     * @param TaxClass $tax_class
     * @return array
     * @throws \Throwable
     */
    public function transform(TaxClass $tax_class)
    {

        $actions = [
            'edit' => [
                'href' => url($this->resource_url . '/' . $tax_class->hashed_id . '/edit'),
                'label' => trans('Corals::labels.edit'),
                'class' => 'modal-load',
                'data' => [
                    'title' => 'Edit Tax Class : ' . $tax_class->name,
                ]
            ],
            'delete' => [
                'href' => url($this->resource_url . '/' . $tax_class->hashed_id),
                'label' => trans('Corals::labels.delete'),
                'data' => [
                    'action' => 'delete',
                    'table' => '.dataTableBuilder'
                ]
            ],
            'taxes' => [
                'icon' => 'fa fa-fw fa-money',
                'href' => url($this->resource_url . '/' . $tax_class->hashed_id . '/taxes'),
                'label' => trans('Payment::module.tax.title'),
                'data' => []
            ],
        ];

        return [
            'id' => $tax_class->id,
            'name' => '<a href="' . url($this->resource_url . '/' . $tax_class->hashed_id . '/taxes') . '">' . $tax_class->name . '</a>',
            'created_at' => format_date($tax_class->created_at),
            'updated_at' => format_date($tax_class->updated_at),
            'action' => $this->actions($tax_class, $actions, null, false),
        ];
    }


}