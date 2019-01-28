<?php

namespace Corals\Modules\Subscriptions\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Transformers\PlanTransformer;
use Yajra\DataTables\EloquentDataTable;

class PlansDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('subscriptions.models.plan.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new PlanTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Plan $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Plan $model)
    {
        $product = $this->request->route('product');
        if (!$product) {
            abort('404');
        }

        return $model->newQuery()->where('product_id', $product->id);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['title' => trans('Subscriptions::attributes.plan.id')],
            'name' => ['title' => trans('Subscriptions::attributes.plan.name')],
            'price' => ['title' => trans('Subscriptions::attributes.plan.price')],
            'bill_cycle' => ['title' => trans('Subscriptions::attributes.plan.bill_cycle')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'display_order' => ['title' => trans('Subscriptions::attributes.plan.display_order')],
            'recommended' => ['title' => trans('Subscriptions::attributes.plan.recommended')],
            'is_visible' => ['title' => trans('Subscriptions::attributes.plan.is_visible')],
            'description' => ['title' => trans('Subscriptions::attributes.plan.description')],
            'free_plan' => ['title' => trans('Subscriptions::attributes.plan.free_plan')],
            'gateway_status' => ['title' => trans('Subscriptions::attributes.plan.gateway_status'), 'orderable' => false, 'searchable' => false],
//            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
