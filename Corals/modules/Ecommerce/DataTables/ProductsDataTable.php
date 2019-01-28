<?php

namespace Corals\Modules\Ecommerce\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Transformers\ProductTransformer;
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
        $this->setResourceUrl(config('ecommerce.models.product.resource_url'));

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
            'image' => ['width' => '50px', 'title' => trans('Ecommerce::attributes.product.image'), 'orderable' => false, 'searchable' => false],
            'name' => ['title' => trans('Ecommerce::attributes.product.name')],
            'type' => ['title' => trans('Ecommerce::attributes.product.type')],
            'price' => ['title' => trans('Ecommerce::attributes.product.price'), 'orderable' => false, 'searchable' => false],
            'shippable' => ['title' => trans('Ecommerce::attributes.product.shippable'), 'orderable' => false, 'searchable' => false],
            'brand' => ['title' => trans('Ecommerce::attributes.product.brand'), 'orderable' => false, 'searchable' => false],
            'categories' => ['title' => trans('Ecommerce::attributes.product.categories'), 'orderable' => false, 'searchable' => false],
            'tags' => ['title' => trans('Ecommerce::attributes.product.tags'), 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'name' => ['title' => trans('Ecommerce::attributes.product.title_name'), 'class' => 'col-md-2', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'description' => ['title' => trans('Ecommerce::attributes.product.description'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'brand.id' => ['title' => trans('Ecommerce::attributes.product.brand'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => \Ecommerce::getBrandsList(), 'active' => true],
            'status' => ['title' => trans('Ecommerce::attributes.product.status_product'), 'class' => 'col-md-2', 'checked_value' => 'active', 'type' => 'boolean', 'active' => true],
        ];
    }
}
