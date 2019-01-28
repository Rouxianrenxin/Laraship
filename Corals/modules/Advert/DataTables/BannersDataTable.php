<?php

namespace Corals\Modules\Advert\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Advert\Models\Banner;
use Corals\Modules\Advert\Models\Campaign;
use Corals\Modules\Advert\Transformers\BannerTransformer;
use Yajra\DataTables\EloquentDataTable;

class BannersDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('advert.models.banner.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new BannerTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Banner $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Banner $model)
    {
        return $model->select('advert_banners.*')->newQuery();
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
            'name' => ['title' => trans('Advert::attributes.banner.name')],
            'campaign' => ['title' => trans('Advert::attributes.banner.campaign'), 'orderable' => false, 'searchable' => false],
            'dimension' => ['title' => trans('Advert::attributes.banner.dimension')],
            'type' => ['title' => trans('Advert::attributes.banner.type')],
            'weight' => ['title' =>trans('Advert::attributes.banner.weight')],
            'notes' => ['title' => trans('Advert::attributes.banner.notes')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'campaign.id' => ['title' => trans('Advert::attributes.banner.campaign'), 'class' => 'col-md-3', 'type' => 'select2', 'options' => Campaign::pluck('name', 'id'), 'active' => true],
        ];
    }
}
