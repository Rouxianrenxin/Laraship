<?php

namespace Corals\Modules\Ecommerce\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Ecommerce\Models\Shipping;
use Corals\Modules\Ecommerce\Transformers\ShippingTransformer;
use Yajra\DataTables\EloquentDataTable;

class ShippingsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('ecommerce.models.shipping.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ShippingTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Shipping $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Shipping $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'priority' => ['title' => trans('Ecommerce::attributes.shipping.priority')],
            'name' => ['title' => trans('Ecommerce::attributes.shipping.name')],
            'exclusive' => ['title' => trans('Ecommerce::attributes.shipping.exclusive')],
            'shipping_method' => ['title' => trans('Ecommerce::attributes.shipping.shipping_method')],
            'country' => ['title' => trans('Ecommerce::attributes.shipping.country')],
            'rate' => ['title' => trans('Ecommerce::attributes.shipping.rate')],
            'min_order_total' => ['title' => trans('Ecommerce::attributes.shipping.min_order_total')],

        ];
    }

    protected function getOptions()
    {
        return ['has_action' => true];
    }
}
