<?php

namespace Corals\Modules\LicenceManager\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\LicenceManager\Models\Licence;
use Corals\Modules\LicenceManager\Transformers\LicenceTransformer;
use Yajra\DataTables\EloquentDataTable;

class LicencesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('licence_manager.models.licence.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new LicenceTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Licence $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Licence $model)
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
            'code' => ['title' => trans('LicenceManager::attributes.licence.code')],
            'licenceable' => ['title' => trans('LicenceManager::attributes.licence.product'), 'searchable' => false, 'orderable' => false],
            'expiry_period' => ['title' => trans('LicenceManager::attributes.licence.expiry_period')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
