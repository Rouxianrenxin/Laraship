<?php

namespace Corals\Modules\Payment\Stripe\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class StripeWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('Stripe::exception.request_did_not_contain'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('Stripe::exception.signature_found_header_named', ['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('Stripe::exception.stripe_secret_not_set'));
    }

    public static function invalidStripePayload(WebhookCall $webhookCall)
    {
        return new static(trans('Stripe::exception.invalid_stripe_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidStripeInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('Stripe::exception.invalid_stripe_invoice', ['arg' => $webhookCall->id]));
    }

    public static function invalidStripeSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('Stripe::exception.invalid_stripe_subscription', ['arg' => $webhookCall->id]));
    }

    public static function invalidStripeCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('Stripe::exception.invalid_stripe_customer', ['arg' => $webhookCall->id]));
    }
}