<?php

namespace Corals\Modules\Payment\Braintree\Job;


use Corals\Modules\Payment\Braintree\Exception\BraintreeWebhookFailed;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Subscription;
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
                throw BraintreeWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;
            if (is_array($payload) && isset($payload['subscription'])) {
                $invoiceObject = $payload['subscription']['transactions'][0];
                $subscription_id = $payload['subscription']['id'];
                $subscription = Subscription::where('subscription_reference', $subscription_id)->first();
                $invoice = Invoice::whereCode($invoiceObject['id'])->first();

                if (!$invoice) {
                    $invoice = Invoice::create([
                        'code' => $invoiceObject['id'],
                        'currency' => $invoiceObject['currencyIsoCode'],
                        'description' => 'Subscription Payment',
                        'sub_total' => ($invoiceObject['amount']),
                        'total' => ($invoiceObject['amount']),
                        'user_id' => $subscription->user_id,
                        'invoicable_id' => $subscription->id,
                        'invoicable_type' => Subscription::class,
                        'due_date' => $invoiceObject['createdAt']['date']
                    ]);
                }

                $invoice->markAsPaid();


                $this->webhookCall->markAsProcessed();
            } else {
                throw BraintreeWebhookFailed::invalidBraintreePayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }

    }
}