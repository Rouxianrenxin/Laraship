<?php

namespace Corals\Modules\Classified\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Classified\Models\Product;
use Corals\Modules\Classified\Transformers\ProductTransformer;
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
        $this->setResourceUrl(config('classified.models.product.resource_url'));

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
            'image' => ['width' => '50px', 'title' => trans('Classified::attributes.product.image'), 'orderable' => false, 'searchable' => false],
            'name' => ['title' => trans('Classified::attributes.product.name')],
            'location' => ['title' => trans('Classified::attributes.product.location'), 'orderable' => false, 'searchable' => false],
            'price' => ['title' => trans('Classified::attributes.product.price'), 'orderable' => false, 'searchable' => false],
            'categories' => ['title' => trans('Classified::attributes.product.categories'), 'orderable' => false, 'searchable' => false],
            'tags' => ['title' => trans('Classified::attributes.product.tags'), 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_by' => ['title' => trans('Corals::attributes.created_by')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'name' => ['title' => trans('Classified::attributes.product.title_name'), 'class' => 'col-md-2', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'location.id' => ['title' => trans('Classified::attributes.product.location'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => \Address::getLocationsList('Classified'), 'active' => true],
            'description' => ['title' => trans('Classified::attributes.product.description'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'status' => ['title' => trans('Classified::labels.product.active_products'), 'class' => 'col-md-2', 'checked_value' => 'active', 'type' => 'boolean', 'active' => true],
        ];
    }
}