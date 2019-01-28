<?php

namespace Corals\Modules\Newsletter\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\Modules\Newsletter\Transformers\SubscriberTransformer;
use Yajra\DataTables\EloquentDataTable;

class SubscriberDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('newsletter.models.subscriber.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new SubscriberTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Subscriber $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Subscriber $model)
    {
        return $model->withCount('mailLists');
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
            'email' => ['title' => trans('Newsletter::attributes.subscriber.email')],
            'name' => ['title' => trans('Newsletter::attributes.subscriber.name')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'mail_lists_count' => ['title' => trans('Newsletter::attributes.subscriber.mail_lists_count'), 'searchable' => false],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'name' => ['title' => trans('Newsletter::attributes.subscriber.name'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'email' => ['title' => trans('Newsletter::attributes.subscriber.email'), 'class' => 'col-md-3', 'type' => 'text', 'condition' => 'like', 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
        ];
    }

}
