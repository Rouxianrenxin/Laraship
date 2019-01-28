<?php

namespace Corals\Modules\Utility\DataTables\Category;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Utility\Models\Category\Attribute;
use Corals\Modules\Utility\Transformers\Category\AttributeTransformer;
use Yajra\DataTables\EloquentDataTable;

class AttributesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility.models.attribute.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new AttributeTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Attribute $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Attribute $model)
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
            'label' => ['title' => trans('Utility::attributes.attributes.label')],
            'type' => ['title' => trans('Utility::attributes.attributes.type')],
            'required' => ['title' => trans('Utility::attributes.attributes.required')],
            'use_as_filter' => ['title' => trans('Utility::attributes.attributes.use_as_filter')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
