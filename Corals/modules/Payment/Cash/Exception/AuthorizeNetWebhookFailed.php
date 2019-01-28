<?php

namespace Corals\Modules\Payment\Cash\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class CashWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('Cash::exception.request_did_not_contain'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('Cash::exception.the_signature_found_header_name', ['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('Cash::exception.cash_sign_secret_not_set'));
    }

    public static function invalidCashPayload(WebhookCall $webhookCall)
    {
        return new static(trans('Cash::exception.invalid_cash_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidCashInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('Cash::exception.invalid_cash_invoice_code', ['arg' => $webhookCall->id]));
    }

    public static function invalidCashSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('Cash::exception.invalid_cash_subscription', ['arg' => $webhookCall->id]));
    }

    public static function invalidCashCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('Cash::exception.invalid_cash_customer', ['arg' => $webhookCall->id]));
    }
}