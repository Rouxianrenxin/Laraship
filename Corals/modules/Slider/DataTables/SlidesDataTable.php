<?php

namespace Corals\Modules\Slider\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Slider\Models\Slide;
use Corals\Modules\Slider\Transformers\SlideTransformer;
use Yajra\DataTables\EloquentDataTable;

class SlidesDataTable extends BaseDataTable
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

        return $dataTable->setTransformer(new SlideTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Slide $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Slide $model)
    {
        $slider = $this->request->route('slider');
        if (!$slider) {
            abort('404');
        }

        return $model->newQuery()->where('slider_id', $slider->id);
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
            'name' => ['title' => trans('Slider::attributes.slide.name')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
