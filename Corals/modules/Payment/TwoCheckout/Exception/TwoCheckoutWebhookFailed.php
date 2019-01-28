<?php

namespace Corals\Modules\Payment\TwoCheckout\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class TwoCheckoutWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('TwoCheckout::exception.request_did_not_contain'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('TwoCheckout::exception.signature_found_header_named', ['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('TwoCheckout::exception.stripe_secret_not_set'));
    }

    public static function invalidTwoCheckoutPayload(WebhookCall $webhookCall)
    {
        return new static(trans('TwoCheckout::exception.invalid_two_checked_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidTwoCheckoutInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('TwoCheckout::exception.invalid_two_checked_invoice', ['arg' => $webhookCall->id]));
    }

    public static function invalidTwoCheckoutSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('TwoCheckout::exception.invalid_two_checked_subscription', ['arg' => $webhookCall->id]));
    }

    public static function invalidTwoCheckoutCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('TwoCheckout::exception.invalid_two_checked_customer', ['arg' => $webhookCall->id]));
    }
}