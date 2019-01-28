<?php

namespace Corals\Modules\Payment\SecurionPay\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class SecurionPayWebhookFailed extends WebhookFailed
{
    public static function invalidSecurionPayPayload(WebhookCall $webhookCall)
    {
        return new static(trans('SecurionPay::exception.invalid_securionpay_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidSecurionPayInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('SecurionPay::exception.invalid_securionpay_invoice', ['arg' => $webhookCall->id]));
    }

    public static function invalidSecurionPaySubscription(WebhookCall $webhookCall)
    {
        return new static(trans('SecurionPay::exception.invalid_securionpay_subscription', ['arg' => $webhookCall->id]));
    }

    public static function invalidSecurionPayCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('SecurionPay::exception.invalid_securionpay_customer', ['arg' => $webhookCall->id]));
    }
}