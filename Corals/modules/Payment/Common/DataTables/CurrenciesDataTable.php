<?php

namespace Corals\Modules\Payment\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Payment\Facades\Payments;
use Corals\Modules\Payment\Models\Currency;
use Corals\Modules\Payment\Common\Transformers\CurrencyTransformer;
use Yajra\DataTables\EloquentDataTable;

class CurrenciesDataTable extends BaseDataTable
{


    public function dataTable($query)
    {
        $this->setResourceUrl(config('payment_common.models.currency.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CurrencyTransformer());
    }

    public function query(currency $model)
    {
        return $model->newQuery();
    }


    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'name' => ['title' => trans('Payment::attributes.currency.name')],
            'code' => ['title' => trans('Payment::attributes.currency.code')],
            'symbol' => ['title' =>  trans('Payment::attributes.currency.symbol')],
            'format' => ['title' => trans('Payment::attributes.currency.format')],
            'active' => ['title' => trans('Corals::attributes.status_options.active')],
            'exchange_rate' => ['title' => trans('Payment::attributes.currency.exchange_rate')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')]
        ];
    }

    protected function getFilters()
    {
        return [
            'name' => ['title' => trans('Payment::attributes.currency.name'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'code' => ['title' => trans('Payment::attributes.currency.code'), 'class' => 'col-md-2', 'type' => 'select', 'options' => Payments::getCodeList(), 'active' => true],
        ];
    }


    protected function getBuilderParameters()
    {
        return ['order' => [5, 'desc']];
    }


}