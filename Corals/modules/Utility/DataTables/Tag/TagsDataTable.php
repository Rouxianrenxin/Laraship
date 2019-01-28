<?php

namespace Corals\Modules\Utility\DataTables\Tag;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Utility\Models\Tag\Tag;
use Corals\Modules\Utility\Transformers\Tag\TagTransformer;
use Yajra\DataTables\EloquentDataTable;

class TagsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility.models.tag.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new TagTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Tag $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Tag $model)
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
            'name' => ['title' => trans('Utility::attributes.tag.name')],
            'slug' => ['title' => trans('Utility::attributes.tag.slug')],
            'module' => ['title' => trans('Utility::attributes.tag.module')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
