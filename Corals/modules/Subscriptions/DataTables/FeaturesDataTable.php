<?php

namespace Corals\Modules\Subscriptions\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Subscriptions\Models\Feature;
use Corals\Modules\Subscriptions\Transformers\FeatureTransformer;
use phpDocumentor\Reflection\Types\Parent_;
use Yajra\DataTables\EloquentDataTable;

class FeaturesDataTable extends BaseDataTable
{


    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $product = $this->request->route('product');
        $url = route(config('subscriptions.models.feature.resource_route'), ['product' => $product->hashed_id]);
        $this->setResourceUrl($url);

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new FeatureTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Feature $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Feature $model)
    {
        $product = $this->request->route('product');
        if (!$product) {
            abort('404');
        }

        return $model->newQuery()->where('product_id', $product->id);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'display_order' => ['title' => trans('Subscriptions::attributes.feature.display_order'), 'visible' => false],
            'id' => ['title' => trans('Subscriptions::attributes.feature.id')],
            'name' => ['title' => trans('Subscriptions::attributes.feature.name'), 'orderable' => false],
            'caption' => ['title' => trans('Subscriptions::attributes.feature.caption'), 'orderable' => false],
            'unit' => ['title' => trans('Subscriptions::attributes.feature.unit'), 'orderable' => false],
            'status' => ['title' => trans('Corals::attributes.status'), 'orderable' => false],
            'type' => ['title' => trans('Subscriptions::attributes.feature.type'), 'orderable' => false],
            'description' => ['title' => trans('Subscriptions::attributes.feature.description'), 'orderable' => false],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'orderable' => false],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at'), 'orderable' => false],
        ];
    }

    protected function getOptions()
    {
        $product = $this->request->route('product');
        $url = route(config('subscriptions.models.feature.resource_route'), ['product' => $product->hashed_id]);
        return ['ordering' => true, 'resource_url' => $url];
    }

    protected function getBuilderParameters()
    {
        return ['order' => [[0, 'asc']]];
    }
}
