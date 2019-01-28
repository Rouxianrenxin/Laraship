<?php

namespace Corals\Modules\Advert\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Advert\Models\Impression;
use Corals\Modules\Advert\Transformers\ImpressionTransformer;
use Yajra\DataTables\EloquentDataTable;

class ImpressionsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('advert.models.impression.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ImpressionTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Impression $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Impression $model)
    {
        return $model->select('advert_impressions.*')->newQuery();
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
            'banner_id' => ['title' => trans('Advert::attributes.impression.banner_id')],
            'zone_id' => ['title' => trans('Advert::attributes.impression.zone_id')],
            'session_id' => ['title' => trans('Advert::attributes.impression.session_id')],
            'page_slug' => ['title' => trans('Advert::attributes.impression.page_slug')],
            'clicked' => ['title' => trans('Advert::attributes.impression.clicked')],
            'visitor_details' => ['title' => trans('Advert::attributes.impression.visitor_details')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }
}
