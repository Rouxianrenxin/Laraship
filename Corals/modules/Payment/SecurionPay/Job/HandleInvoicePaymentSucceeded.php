<?php

namespace Corals\Modules\Payment\SecurionPay\Job;


use Corals\Modules\Payment\SecurionPay\Exception\SecurionPayWebhookFailed;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Payment\Models\WebhookCall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleInvoicePaymentSucceeded implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Corals\Modules\Payment\Models\WebhookCall
     */
    public $webhookCall;

    /**
     * HandleInvoiceCreated constructor.
     * @param WebhookCall $webhookCall
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        logger('Invoice Payment Succeeded');

        try {
            if ($this->webhookCall->processed) {
                throw SecurionPayWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload) && isset($payload['data']['objectType']) && $payload['data']['objectType'] == 'charge') {
                $invoiceObject = $payload['data'];

                $invoiceCode = $invoiceObject['id'];

                if ($invoiceObject['captured']) {
                    $invoice = Invoice::whereCode($invoiceCode)->first();

                    if (!$invoice) {
                        throw SecurionPayWebhookFailed::invalidSecurionPayInvoice($this->webhookCall);
                    }

                    $invoice->markAsPaid();
                } else {
                    throw SecurionPayWebhookFailed::invalidSecurionPayPayload($this->webhookCall);
                }

                $this->webhookCall->markAsProcessed();
            } else {
                throw SecurionPayWebhookFailed::invalidSecurionPayPayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }
    }
}