<?php

namespace Corals\Modules\Payment\Stripe\Job;


use Corals\Modules\Payment\Stripe\Exception\StripeWebhookFailed;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Payment\Models\WebhookCall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleCustomerSubscriptionDeleted implements ShouldQueue
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
                throw StripeWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload) && isset($payload['data']['object'])) {
                $subscriptionObject = $payload['data']['object'];

                $subscriptionObjectReference = $subscriptionObject['id'];

                $subscription = Subscription::where('subscription_reference', $subscriptionObjectReference)->first();

                if (!$subscription) {
                    throw StripeWebhookFailed::invalidStripeSubscription($this->webhookCall);
                }
                \Actions::do_action('pre_webhook_cancel_subscription', $subscription);

                $subscription->setStatus('canceled');
                $subscription->markAsCancelled();

                $this->webhookCall->markAsProcessed();

                \Actions::do_action('post_webhook_cancel_subscription', $subscription);
            } else {
                throw StripeWebhookFailed::invalidStripePayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }
    }
}