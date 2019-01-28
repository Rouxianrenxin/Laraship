<?php

namespace Corals\Modules\Payment\Braintree\Job;


use Carbon\Carbon;
use Corals\Modules\Payment\Braintree\Exception\BraintreeWebhookFailed;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Payment\Models\WebhookCall;
use Corals\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleInvoiceCreated implements ShouldQueue
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
        logger('Invoice Created job, webhook_call: ' . $this->webhookCall->id);

        try {

            if ($this->webhookCall->processed) {
                throw BraintreeWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload) && isset($payload['resource'])) {
                $invoiceObject = $payload['resource'];

                $subscription = Subscription::where('subscription_reference', $invoiceObject['billing_agreement_id'])->first();

                if (!$subscription) {
                    throw BraintreeWebhookFailed::invalidBraintreeSubscription($this->webhookCall);
                }

                $invoice = Invoice::create([
                    'code' => $invoiceObject['id'],
                    'currency' => $invoiceObject['total_amount']['currency'],
                    'description' => $payload['summary'],
                    'sub_total' => ($invoiceObject['total_amount']['value']),
                    'total' => ($invoiceObject['total_amount']['value']),
                    'user_id' => $subscription->user_id,
                    'invoicable_id' => $subscription->id,
                    'invoicable_type' => Subscription::class,
                    'due_date' => Carbon::createFromTimestamp($invoiceObject['date']),
                ]);


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