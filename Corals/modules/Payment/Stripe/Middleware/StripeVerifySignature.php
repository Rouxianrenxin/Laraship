<?php

namespace Corals\Modules\Payment\Stripe\Middleware;

use Closure;
use Corals\Modules\Subscriptions\Classes\Subscription;
use Corals\Modules\Payment\Stripe\Exception\StripeWebhookFailed;
use Exception;
use Stripe\Webhook;

class StripeVerifySignature
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws StripeWebhookFailed
     */
    public function handle($request, Closure $next)
    {
        $signature = $request->header('Stripe-Signature');

        if (!$signature) {
            throw StripeWebhookFailed::missingSignature();
        }

        if (!$this->isValid($signature, $request->getContent())) {
            throw StripeWebhookFailed::invalidSignature($signature);
        }

        return $next($request);
    }

    /**
     * @param string $signature
     * @param string $payload
     * @return bool
     * @throws StripeWebhookFailed
     */
    protected function isValid(string $signature, string $payload): bool
    {
        $subscription = new Subscription('Stripe');

        $webhook_secret = $subscription->gateway->getApiWebhookKey();

        if (empty($webhook_secret)) {
            throw StripeWebhookFailed::signingSecretNotSet();
        }
        try {
            Webhook::constructEvent($payload, $signature, $webhook_secret);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}