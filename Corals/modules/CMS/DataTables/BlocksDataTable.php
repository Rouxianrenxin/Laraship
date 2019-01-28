<?php

namespace Corals\Modules\CMS\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\CMS\Models\Block;
use Corals\Modules\CMS\Transformers\BlockTransformer;
use Yajra\DataTables\EloquentDataTable;

class BlocksDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('cms.models.block.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new BlockTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Block $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Block $model)
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
            'name' => ['title' => trans('CMS::attributes.block.name')],
            'key' => ['title' => trans('CMS::attributes.block.key')],
            'short_code' => ['title' => trans('CMS::attributes.block.short_code'), 'searchable' => false, 'ordarable' => false],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
