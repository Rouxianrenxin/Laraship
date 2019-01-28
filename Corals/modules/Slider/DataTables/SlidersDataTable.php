<?php

namespace Corals\Modules\Slider\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Slider\Models\Slider;
use Corals\Modules\Slider\Transformers\SliderTransformer;
use Yajra\DataTables\EloquentDataTable;

class SlidersDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('slider.models.slider.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new SliderTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Slider $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Slider $model)
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
            'name' => ['title' => trans('Slider::attributes.slider.name')],
            'key' => ['title' => trans('Slider::attributes.slider.key')],
            'type' => ['title' => trans('Slider::attributes.slider.type')],
            'short_code' => ['title' => trans('Slider::attributes.slider.short_code'), 'searchable' => false, 'ordarable' => false],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
