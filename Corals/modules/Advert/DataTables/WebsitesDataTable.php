<?php

namespace Corals\Modules\Advert\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Advert\Models\Website;
use Corals\Modules\Advert\Transformers\WebsiteTransformer;
use Yajra\DataTables\EloquentDataTable;

class WebsitesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('advert.models.website.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new WebsiteTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Website $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Website $model)
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
            'name' => ['title' => trans('Advert::attributes.website.name')],
            'url' => ['title' => trans('Advert::attributes.website.url')],
            'contact' => ['title' => trans('Advert::attributes.website.contact')],
            'email' => ['title' => trans('Advert::attributes.website.email')],
            'notes' => ['title' => trans('Advert::attributes.website.notes')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
