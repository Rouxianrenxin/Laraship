<?php

namespace Corals\Modules\Payment\PayPal\Job;


use Carbon\Carbon;
use Corals\Modules\Payment\PayPal\Exception\PayPalWebhookFailed;
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
                throw PayPalWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload) && isset($payload['resource'])) {
                $invoiceObject = $payload['resource'];
                if (isset($invoiceObject['billing_agreement_id']) && $invoiceObject['billing_agreement_id']) {
                    $subscription = Subscription::where('subscription_reference', $invoiceObject['billing_agreement_id'])->first();

                    if (!$subscription) {
                        throw PayPalWebhookFailed::invalidPayPalSubscription($this->webhookCall);
                    }
                    Invoice::create([
                        'code' => $invoiceObject['id'],
                        'currency' => $invoiceObject['amount']['currency'],
                        'description' => $payload['summary'],
                        'sub_total' => ($invoiceObject['amount']['total']),
                        'total' => ($invoiceObject['amount']['total']),
                        'user_id' => $subscription->user_id,
                        'invoicable_id' => $subscription->id,
                        'invoicable_type' => Subscription::class,
                        'due_date' => Carbon::parse($invoiceObject['create_time']),
                    ]);

                }


                $this->webhookCall->markAsProcessed();
            } else {
                throw PayPalWebhookFailed::invalidPayPalPayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }
    }
}