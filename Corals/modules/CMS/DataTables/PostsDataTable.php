<?php

namespace Corals\Modules\CMS\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\CMS\Facades\CMS;
use Corals\Modules\CMS\Models\Post;
use Corals\Modules\CMS\Transformers\PostTransformer;
use Yajra\DataTables\EloquentDataTable;

class PostsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('cms.models.post.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new PostTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Post $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Post $model)
    {
        return $model->with('categories');
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
            'title' => ['title' => trans('CMS::attributes.content.title')],
            'slug' => ['title' => trans('CMS::attributes.content.slug')],
            'published' => ['title' => trans('CMS::attributes.content.published')],
            'published_at' => ['title' => trans('CMS::attributes.content.published_at')],
            'categories' => ['name' => 'categories.name', 'title' => trans('CMS::attributes.content.categories'), 'orderable' => false],
            'private' => ['title' => trans('CMS::attributes.content.private')],
            'internal' => ['title' => trans('CMS::attributes.content.internal')],
        ];
    }

    protected function getFilters()
    {
        return [
            'title' => ['title' => trans('CMS::attributes.content.title'), 'class' => 'col-md-4', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'slug' => ['title' => trans('CMS::attributes.content.slug'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'categories.id' => ['title' => trans('CMS::attributes.content.title'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => CMS::getCategoriesList(false, null, null, 'post'), 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
            'published' => ['title' => trans('CMS::labels.post.show_published_only'), 'class' => 'col-md-2', 'type' => 'boolean', 'active' => true],
        ];
    }
}
