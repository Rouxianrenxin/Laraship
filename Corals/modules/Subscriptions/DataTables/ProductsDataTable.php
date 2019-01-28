<?php

namespace Corals\Modules\Subscriptions\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\Modules\Subscriptions\Transformers\ProductTransformer;
use Yajra\DataTables\EloquentDataTable;

class ProductsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('subscriptions.models.product.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ProductTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Product $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Product $model)
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
            'image' => ['width' => '50px', 'title' => trans('Subscriptions::attributes.product.image'), 'orderable' => false, 'searchable' => false],
            'name' => ['title' => trans('Subscriptions::attributes.product.name')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'short_code' => ['title' => trans('Subscriptions::attributes.product.short_code'), 'searchable' => false, 'ordarable' => false],
            'description' => ['title' => trans('Subscriptions::attributes.product.description')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
