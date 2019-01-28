<?php

namespace Corals\Modules\Newsletter\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Transformers\EmailTransformer;
use Yajra\DataTables\EloquentDataTable;

class EmailDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('newsletter.models.email.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new EmailTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Email $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Email $model)
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
            'subject' => ['title' => trans('Newsletter::attributes.email.subject')],
            'mail_lists' => ['title' => trans('Newsletter::attributes.email.mail_lists'), 'searchable' => false, 'orderable' => false],
            'subscribers' => ['title' => trans('Newsletter::attributes.email.subscribers'), 'searchable' => false, 'orderable' => false],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'status' => ['title' => trans('Corals::attributes.status'), 'class' => 'col-md-2', 'type' => 'select', 'options' => get_array_key_translation(config('newsletter.models.email.status_options')), 'active' => true],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
        ];
    }

}
