<?php

namespace Corals\Modules\Payment\Omise\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class OmiseWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('Omise::exception.request_did_not_contain'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('Omise::exception.signature_found_header_named', ['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('Omise::exception.stripe_secret_not_set'));
    }

    public static function invalidOmisePayload(WebhookCall $webhookCall)
    {
        return new static(trans('Omise::exception.invalid_two_checked_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidOmiseInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('Omise::exception.invalid_two_checked_invoice', ['arg' => $webhookCall->id]));
    }

    public static function invalidOmiseSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('Omise::exception.invalid_two_checked_subscription', ['arg' => $webhookCall->id]));
    }

    public static function invalidOmiseCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('Omise::exception.invalid_two_checked_customer', ['arg' => $webhookCall->id]));
    }
}