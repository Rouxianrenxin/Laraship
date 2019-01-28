<?php

namespace Corals\Modules\Advert\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Advert\Models\Website;
use Corals\Modules\Advert\Models\Zone;
use Corals\Modules\Advert\Transformers\ZoneTransformer;
use Yajra\DataTables\EloquentDataTable;

class ZonesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('advert.models.zone.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ZoneTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Zone $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Zone $model)
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
            'name' => ['title' => trans('Advert::attributes.zone.name')],
            'website' => ['title' => trans('Advert::attributes.zone.website'), 'orderable' => false, 'searchable' => false],
            'key' => ['title' => trans('Advert::attributes.zone.key')],
            'dimension' => ['title' => trans('Advert::attributes.zone.dimension')],
            'notes' => ['title' => trans('Advert::attributes.zone.notes')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'website.id' => ['title' => 'Website', 'class' => 'col-md-3', 'type' => 'select2', 'options' => Website::pluck('name', 'id'), 'active' => true],
        ];
    }
}
