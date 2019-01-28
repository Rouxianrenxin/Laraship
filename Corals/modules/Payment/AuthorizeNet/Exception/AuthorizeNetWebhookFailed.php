<?php

namespace Corals\Modules\Payment\AuthorizeNet\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class AuthorizeNetWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('AuthorizeNet::exception.request_not_contain_header'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('AuthorizeNet::exception.signature_found_header_name', ['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('AuthorizeNet::exception.authorize_webhook_sing_secret'));
    }

    public static function invalidAuthorizeNetPayload(WebhookCall $webhookCall)
    {
        return new static(trans('AuthorizeNet::exception.invalid_authorize_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidAuthorizeNetInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('AuthorizeNet::exception.invalid_authorize_invoice_code', ['arg' => $webhookCall->id]));
    }

    public static function invalidAuthorizeNetSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('AuthorizeNet::exception.invalid_authorize_subscription_Reference', ['arg' => $webhookCall->id]));
    }

    public static function invalidAuthorizeNetCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('AuthorizeNet::exception.invalid_authorize_customer', ['arg' => $webhookCall->id]));
    }
}