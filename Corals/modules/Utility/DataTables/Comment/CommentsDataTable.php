<?php

namespace Corals\Modules\Utility\DataTables\Comment;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Utility\Models\Comment\Comment;
use Corals\Modules\Utility\Transformers\Comment\CommentTransformer;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;

class CommentsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('utility.models.comment.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CommentTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Comment $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Comment $model,Request $request)
    {
        if ($request->has('commentable_id') && $request->has('commentable_type')) {

            return $model->comments($request->input('commentable_id'),$request->input('commentable_type'))->newQuery();
        }else{
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
            'commentable_id' => ['title' => trans('Utility::attributes.comments.title')],
            'body' => ['title' => trans('Utility::attributes.rating.body')],

            'author_id' => ['title' => trans('Utility::attributes.rating.author')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'body' => ['title' => trans('Utility::attributes.rating.body'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
        ];
    }
}
