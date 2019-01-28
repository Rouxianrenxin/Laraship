<?php

namespace Corals\Modules\Utility\DataTables\Category;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Utility\Models\Category\Category;
use Corals\Modules\Utility\Transformers\Category\CategoryTransformer;
use Yajra\DataTables\EloquentDataTable;

class CategoriesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility.models.category.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CategoryTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Category $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Category $model)
    {
//        return $model->withCount('products');
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
            'name' => ['title' => trans('Utility::attributes.category.name')],
            'slug' => ['title' => trans('Utility::attributes.category.slug')],
            'parent_id' => ['title' => trans('Utility::attributes.category.parent_id')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'name' => ['title' => trans('Utility::attributes.category.name'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'parent.id' => ['title' => trans('Utility::attributes.category.parent_id'), 'class' => 'col-md-2', 'type' => 'select', 'options' => \Category::getCategoriesList(null, true), 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
        ];
    }
}
