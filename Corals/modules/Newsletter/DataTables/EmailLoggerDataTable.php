<?php

namespace Corals\Modules\Newsletter\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Newsletter\Models\EmailLogger;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Transformers\EmailLoggerTransformer;
use Yajra\DataTables\EloquentDataTable;

class EmailLoggerDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('newsletter.models.email_logger.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new EmailLoggerTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Email $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(EmailLogger $model)
    {
        return $model->with('subscriber')->with('email');
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
            'subscriber_name' => ['title' => trans('Newsletter::attributes.subscriber.name'), 'searchable' => false, 'orderable' => false],
            'subscriber_email' => ['title' => trans('Newsletter::attributes.subscriber.email'), 'searchable' => false, 'orderable' => false],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'status' => ['title' => trans('Corals::attributes.status'), 'class' => 'col-md-2', 'type' => 'select', 'options' => get_array_key_translation(config('newsletter.models.email_logger.status_options')), 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-2', 'type' => 'date', 'active' => true],
        ];
    }

}
