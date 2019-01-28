<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Payment\Models\Transaction;

class TransactionTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.models.transaction.resource_url');

        parent::__construct();
    }

    /**
     * @param Transaction $transaction
     * @return array
     * @throws \Throwable
     */
    public function transform(Transaction $transaction)
    {
        $actions = [];
        if (!user()->hasPermissionTo('Payment::transaction.update')) {
            $actions['edit'] = '';
        }
        if (!user()->hasPermissionTo('Payment::transaction.delete')) {
            $actions['delete'] = '';
        }


        $invoice_resource_url = config('payment_common.models.invoice.resource_url');

        $levels = [
            'pending' => 'info',
            'processing' => 'success',
            'completed' => 'primary',
            'failed' => 'danger',
            'cancelled' => 'warning'
        ];

        $payment_currency = strtoupper($transaction->paid_currency);

        $invoice_link = $transaction->invoice ? '<a target="_blank" href="' . url($invoice_resource_url . '/' . $transaction->invoice->hashed_id . '/download') . '">' . $transaction->invoice->code . '</a>' : '-';
        return [
            'id' => $transaction->id,
            'invoice' => $invoice_link,
            'status' => formatStatusAsLabels($transaction->status, ['level' => $levels[$transaction->status], 'text' => trans('Payment::status.transaction.' . $transaction->status)]),
            'source' => $transaction->sourcable ? $transaction->sourcable->getTransactionSource() : '-',
            'type' => trans('Payment::attributes.transaction.types.' . $transaction->type),
            'exception' => $transaction->exception ? generatePopover("'" . $transaction->getOriginal('exception') . "'") : '-',
            'gateway' => $transaction->gateway,
            'paid_amount' => $transaction->paid_amount ? currency()->format($transaction->paid_amount, $payment_currency) : '-',
            'reference' => $transaction->reference,
            'amount' => \Payments::admin_currency($transaction->amount),
            'notes' => generatePopover("'" . $transaction->getOriginal('notes') . "'"),
            'processed' => $transaction->processed ? '<i class="fa fa-check text-success"></i>' : '-',
            'created_at' => format_date($transaction->created_at),
            'updated_at' => format_date($transaction->updated_at),
            'action' => $this->actions($transaction, $actions)
        ];
    }
}