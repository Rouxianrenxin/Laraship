<?php

namespace Corals\Modules\Ecommerce\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Ecommerce\Transformers\OrderTransformer;
use Corals\Modules\Ecommerce\Transformers\PrivatePagesTransformer;
use Corals\User\Models\User;
use Yajra\DataTables\EloquentDataTable;

class MyPrivatePagesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new PrivatePagesTransformer());
    }

    /**
     * Get query source of dataTable.
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query()
    {
        return user()->posts()->select('postables.*')->newQuery();
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
            'order_number' => ['title' => trans('Ecommerce::attributes.order.order_primary')],
            'page_link' => ['title' => trans('Ecommerce::attributes.order.page_link')],
        ];
    }

    protected function getOptions()
    {
        return ['has_action' => false];
    }
}
