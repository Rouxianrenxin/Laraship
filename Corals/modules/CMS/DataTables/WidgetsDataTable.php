<?php

namespace Corals\Modules\CMS\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\CMS\Models\Widget;
use Corals\Modules\CMS\Transformers\WidgetTransformer;
use Yajra\DataTables\EloquentDataTable;

class WidgetsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('cms.models.widget.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new WidgetTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Widget $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Widget $model)
    {
        $block = $this->request->route('block');
        if (!$block) {
            abort('404');
        }

        return $model->newQuery()->where('block_id', $block->id);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'widget_order' => ['title' => trans('Subscriptions::attributes.feature.display_order'), 'visible' => false],
            'id' => ['title' => trans('CMS::attributes.widget.id'), 'sorting' => false],
            'title' => ['title' => trans('CMS::attributes.widget.title'), 'sorting' => false],
            'status' => ['title' => trans('Corals::attributes.status'), 'sorting' => false],
            'widget_width' => ['title' => trans('CMS::attributes.widget.widget_width'), 'sorting' => false],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'sorting' => false],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at'), 'sorting' => false],
        ];
    }

    protected function getOptions()
    {
        $block = $this->request->route('block');
        $url = route(config('cms.models.widget.resource_route'), ['block' => $block->hashed_id]);
        return ['ordering' => true, 'resource_url' => $url];
    }

    protected function getBuilderParameters()
    {
        return ['order' => [[0, 'asc']]];
    }
}
