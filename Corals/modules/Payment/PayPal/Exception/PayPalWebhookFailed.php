<?php

namespace Corals\Modules\Payment\PayPal\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class PayPalWebhookFailed extends WebhookFailed
{

    public static function invalidPayPalPayload(WebhookCall $webhookCall)
    {
        return new static(trans('PayPal::exception.invalid_paypal', ['arg' => $webhookCall->id]));
    }

    public static function invalidPayPalInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('PayPal::exception.invalid_paypal_invoice', ['arg' => $webhookCall->id]));
    }

    public static function invalidPayPalSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('PayPal::exception.invalid_paypal_subscription', ['arg' => $webhookCall->id]));
    }

    public static function invalidPayPalCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('PayPal::exception.invalid_paypal_customer', ['arg' => $webhookCall->id]));
    }
}