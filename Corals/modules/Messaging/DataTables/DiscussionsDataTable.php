<?php

namespace Corals\Modules\Messaging\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Messaging\Models\Discussion;
use Corals\Modules\Messaging\Transformers\DiscussionTransformer;
use Yajra\DataTables\EloquentDataTable;

class DiscussionsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('messaging.models.discussion.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new DiscussionTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Discussion $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Discussion $model)
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
            
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
