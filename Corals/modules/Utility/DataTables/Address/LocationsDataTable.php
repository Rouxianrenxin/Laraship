<?php

namespace Corals\Modules\Utility\DataTables\Address;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Utility\Models\Address\Location;
use Corals\Modules\Utility\Transformers\Address\LocationTransformer;
use Yajra\DataTables\EloquentDataTable;

class LocationsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility.models.location.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new LocationTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Location $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Location $model)
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
            'name' => ['title' => trans('Utility::attributes.location.name')],
            'address' => ['title' => trans('Utility::attributes.location.address')],
            'lat' => ['title' => trans('Utility::attributes.location.lat')],
            'long' => ['title' => trans('Utility::attributes.location.long')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
