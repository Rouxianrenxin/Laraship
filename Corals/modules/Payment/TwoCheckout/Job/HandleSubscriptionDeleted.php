<?php

namespace Corals\Modules\Payment\TwoCheckout\Job;


use Corals\Modules\Payment\TwoCheckout\Exception\TwoCheckoutWebhookFailed;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Payment\Models\WebhookCall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleSubscriptionDeleted implements ShouldQueue
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
        logger('customer.subscription.deleted');

        try {
            if ($this->webhookCall->processed) {
                throw TwoCheckoutWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;


            if (is_array($payload)) {

                $sale_id = $payload['sale_id'];
                $subscription = Subscription::where('subscription_reference', 'like', "$sale_id|%")->first();


                if (!$subscription) {
                    throw TwoCheckoutWebhookFailed::invalidTwoCheckoutSubscription($this->webhookCall);
                }
                \Actions::do_action('pre_webhook_cancel_subscription', $subscription);

                $subscription->setStatus('canceled');
                $subscription->markAsCancelled();

                $this->webhookCall->markAsProcessed();

                \Actions::do_action('post_webhook_cancel_subscription', $subscription);
            } else {
                throw TwoCheckoutWebhookFailed::invalidTwoCheckoutPayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }
    }
}