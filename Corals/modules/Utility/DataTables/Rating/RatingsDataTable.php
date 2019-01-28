<?php

namespace Corals\Modules\Utility\DataTables\Rating;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Utility\Models\Rating\Rating;
use Corals\Modules\Utility\Transformers\Rating\RatingTransformer;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Http\Request;

class RatingsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility.models.rating.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new RatingTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Rating $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Rating $model,Request $request)
    {
        if (!isSuperUser()) {

            return $model->reviews()->newQuery();
        }else {
            return $model->newQuery();
        }
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
            'rating' => ['title' => trans('Utility::attributes.rating.rating')],
            'title' => ['title' => trans('Utility::attributes.rating.title')],
            'body' => ['title' => trans('Utility::attributes.rating.body')],
            'reviewrateable_id' => ['title' => trans('Utility::attributes.rating.model')],
            'reviewrateable_type' => ['title' => trans('Utility::attributes.rating.type')],
            'author_id' => ['title' => trans('Utility::attributes.rating.author')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'comments_count' => ['title' => trans('Utility::attributes.rating.comments_count')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'title' => ['title' => trans('Utility::attributes.rating.title'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'rating' => ['title' => trans('Utility::attributes.rating.rating'), 'class' => 'col-md-2', 'type' => 'select', 'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4 , 5 => 5], 'active' => true],
        ];
    }
}
