<?php

namespace Corals\Modules\Payment\Braintree\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class BraintreeWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('Braintree::exception.request_did_not_contain_header_named'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('Braintree::exception.the_signature_found_header_named', ['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('Braintree::exception.braintree_webhook_sing_secret_not_set'));
    }

    public static function invalidBraintreePayload(WebhookCall $webhookCall)
    {
        return new static(trans('Braintree::exception.invalid_braintree_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidBraintreeInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('Braintree::exception.invalid_braintree_invoice_code', ['arg' => $webhookCall->id]));
    }

    public static function invalidBraintreeSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('Braintree::exception.invalid_braintree_subscription_reference', ['arg' => $webhookCall->id]));
    }

    public static function invalidBraintreeCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('Braintree::exception.invalid_braintree_customer', ['arg' => $webhookCall->id]));
    }
}