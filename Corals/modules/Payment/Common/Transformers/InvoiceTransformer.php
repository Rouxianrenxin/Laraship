<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Payment\Models\Invoice;

class InvoiceTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.models.invoice.resource_url');

        parent::__construct();
    }

    /**
     * @param Invoice $invoice
     * @return array
     * @throws \Throwable
     */
    public function transform(Invoice $invoice)
    {
        $actions = ['download' => [

            'href' => url($this->resource_url . '/' . $invoice->hashed_id . '/download'),
            'label' => trans('Corals::labels.download'),
            'target' => '_blank',
            'data' => []
        ], 'delete' => ''];

        if (!user()->hasPermissionTo('Payment::invoices.update')) {
            $actions['edit'] = '';
        }

        $currency = strtoupper($invoice->currency);

        if ($invoice->status == "pending") {
            $status = '<span class="label label-info">' . trans('Payment::labels.invoice.pending') . '</span>';
        } elseif ($invoice->status == "paid") {
            $status = '<span class="label label-success">' . trans('Payment::labels.invoice.paid') . '</span>';
        } else {
            $status = '<span class="label label-danger">' . trans('Payment::labels.invoice.failed') . '</span>';

        }

        return [
            'id' => $invoice->id,
            'status' => $status,
            'code' => $invoice->code,
            'currency' => $currency,
            'description' => $invoice->description ? generatePopover($invoice->description) : '-',
            'due_date' => format_date($invoice->due_date),
            'sub_total' => currency()->format($invoice->sub_total, $currency),
            'total' => currency()->format($invoice->total, $currency),
            'user_id' => $invoice->user ? "<a href='" . url('users/' . $invoice->user->hashed_id) . "'> {$invoice->user->full_name}</a>" : "-",
            'invoicable_type' => class_basename($invoice->invoicable_type),
            'invoicable_id' => $invoice->invoicable ? $invoice->invoicable->getInvoiceReference() : '-',
            'created_at' => format_date($invoice->created_at),
            'updated_at' => format_date($invoice->updated_at),
            'action' => $this->actions($invoice, $actions)
        ];
    }
}