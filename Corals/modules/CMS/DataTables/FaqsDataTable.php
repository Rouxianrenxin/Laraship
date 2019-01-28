<?php


namespace Corals\Modules\CMS\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\CMS\Facades\CMS;
use Corals\Modules\CMS\Models\Faq;
use Corals\Modules\CMS\Transformers\FaqTransformer;
use Yajra\DataTables\EloquentDataTable;

class FaqsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('cms.models.faq.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new FaqTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Faq $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Faq $model)
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
            'title' => ['title' => trans('CMS::attributes.content.title')],
            'published' => ['title' => trans('CMS::attributes.content.published')],
            'published_at' => ['title' => trans('CMS::attributes.content.published_at')],
            'categories' => ['name' => 'categories.name', 'title' => trans('CMS::attributes.content.categories'), 'orderable' => false],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'title' => ['title' => trans('CMS::attributes.content.title'), 'class' => 'col-md-4', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'categories.id' => ['title' => trans('CMS::attributes.content.title'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => CMS::getCategoriesList(false, null, null, 'faq'), 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
            'published' => ['title' => trans('CMS::labels.post.show_published_only'), 'class' => 'col-md-2', 'type' => 'boolean', 'active' => true],
        ];
    }
}
