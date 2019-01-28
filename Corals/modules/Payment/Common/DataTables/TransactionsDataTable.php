<?php

namespace Corals\Modules\Payment\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Payment\Models\Transaction;
use Corals\Modules\Payment\Common\Transformers\TransactionTransformer;
use Yajra\DataTables\EloquentDataTable;

class TransactionsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('payment_common.models.transaction.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new TransactionTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Transaction $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Transaction $model)
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
            'id' => ['visible' => true],
            'invoice' => ['title' => trans('Payment::attributes.transaction.invoice'), 'searchable' => false, 'orderable' => false],
            'type' => ['title' => trans('Payment::attributes.transaction.type'), 'searchable' => false, 'orderable' => false],
            'status' => ['title' => trans('Payment::attributes.transaction.status')],
            'source' => ['title' => trans('Payment::attributes.transaction.source'), 'searchable' => false, 'orderable' => false],
            'amount' => ['title' => trans('Payment::attributes.transaction.amount')],
            'paid_amount' => ['title' => trans('Payment::attributes.transaction.paid_amount')],
            'notes' => ['title' => trans('Payment::attributes.transaction.notes')],
            'reference' => ['title' => trans('Payment::attributes.transaction.reference')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')]
        ];
    }

    protected function getBulkActions()
    {
        return [

        ];
    }

    protected function getOptions()
    {
        $url = url(config('payment_common.models.transaction.resource_url'));
        return ['resource_url' => $url];
    }
}
