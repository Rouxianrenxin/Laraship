<?php

namespace Corals\Modules\Ecommerce\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Ecommerce\Models\Coupon;
use Corals\Modules\Ecommerce\Transformers\CouponTransformer;
use Yajra\DataTables\EloquentDataTable;

class CouponsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('ecommerce.models.coupon.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CouponTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Coupon $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Coupon $model)
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
            'code' => ['title' => trans('Ecommerce::attributes.coupon.code')],
            'value' => ['title' => trans('Ecommerce::attributes.coupon.value')],
            'status' => ['title' => trans('Corals::attributes.status'), 'orderable' => false, 'searchable' => false],
            'type' => ['title' => trans('Ecommerce::attributes.coupon.type')],
            'start' => ['title' => trans('Ecommerce::attributes.coupon.start')],
            'expiry' => ['title' => trans('Ecommerce::attributes.coupon.expiry')]
        ];
    }

    protected function getOptions()
    {
        return ['has_action' => true];
    }
}
