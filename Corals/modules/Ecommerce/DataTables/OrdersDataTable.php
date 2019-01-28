<?php

namespace Corals\Modules\Ecommerce\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Ecommerce\Transformers\OrderTransformer;
use Yajra\DataTables\EloquentDataTable;

class OrdersDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('ecommerce.models.order.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new OrderTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Order $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Order $model)
    {
        return $model->with('user')->newQuery();
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
            'order_number' => ['title' => trans('Ecommerce::attributes.order.order_number')],
            'amount' => ['title' => trans('Ecommerce::attributes.order.amount')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'user_id' => ['title' => trans('Ecommerce::attributes.order.user_id')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')]
        ];
    }

    protected function getOptions()
    {
        return ['has_action' => true];
    }
}
