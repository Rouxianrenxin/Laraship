<?php

namespace Corals\Modules\Directory\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Directory\Facades\Directory;
use Corals\Modules\Directory\Models\Claim;
use Corals\Modules\Directory\Transformers\ClaimTransformer;
use Yajra\DataTables\EloquentDataTable;

class ClaimsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('directory.models.listing.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ClaimTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Claim $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Claim $model)
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
            'requester' => ['title' => trans('Directory::attributes.claim.requester')],
            'listing' => ['title' => trans('Directory::attributes.listing.title_name')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }
}