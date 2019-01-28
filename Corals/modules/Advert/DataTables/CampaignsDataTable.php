<?php

namespace Corals\Modules\Advert\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Advert\Models\Advertiser;
use Corals\Modules\Advert\Models\Campaign;
use Corals\Modules\Advert\Transformers\CampaignTransformer;
use Yajra\DataTables\EloquentDataTable;

class CampaignsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CampaignTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Campaign $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Campaign $model)
    {
        return $model->select('advert_campaigns.*')->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            'id' => ['visible' => false],
            'name' => ['title' => trans('Advert::attributes.campaign.name')],
            'starts_at' => ['title' => trans('Advert::attributes.campaign.starts_at')],
            'ends_at' => ['title' => trans('Advert::attributes.campaign.ends_at')],
            'notes' => ['title' => trans('Advert::attributes.campaign.notes')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
        if (user()->hasPermissionTo('Advert::advertiser.view')) {
            $columns['advertiser'] = ['title' => trans('Advert::attributes.campaign.advertiser'), 'orderable' => false, 'searchable' => false];
        }
        return $columns;
    }

    protected function getFilters()
    {
        return [
            'advertiser.id' => ['title' => trans('Advert::attributes.campaign.advertiser'), 'class' => 'col-md-3', 'type' => 'select2', 'options' => Advertiser::pluck('name', 'id'), 'active' => true],
        ];
    }
}
