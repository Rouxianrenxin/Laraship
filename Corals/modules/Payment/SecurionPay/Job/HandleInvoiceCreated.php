<?php

namespace Corals\Modules\Payment\SecurionPay\Job;


use Carbon\Carbon;
use Corals\Modules\Payment\SecurionPay\Exception\SecurionPayWebhookFailed;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Plan;
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
                throw SecurionPayWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload) && isset($payload['data']['objectType']) && $payload['data']['objectType'] == 'charge') {
                $invoiceObject = $payload['data'];

                $user = User::where('integration_id', $invoiceObject['customerId'])->first();

                if (!$user) {
                    throw SecurionPayWebhookFailed::invalidSecurionPayCustomer($this->webhookCall);
                }

                if (isset($invoiceObject['subscriptionId'])) {

                    $subscription = Subscription::where('subscription_reference', $invoiceObject['subscriptionId'])->first();

                    if (!$subscription) {
                        throw SecurionPayWebhookFailed::invalidSecurionPaySubscription($this->webhookCall);
                    }

                    $invoice = Invoice::create([
                        'code' => $invoiceObject['id'],
                        'currency' => $invoiceObject['currency'],
                        'description' => null,
                        'sub_total' => ($invoiceObject['amount'] / 100),
                        'total' => ($invoiceObject['amount'] / 100),
                        'user_id' => $user->id,
                        'invoicable_id' => $subscription->id,
                        'invoicable_type' => Subscription::class,
                        'due_date' => Carbon::createFromTimestamp($invoiceObject['created']),
                    ]);
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