<?php

namespace Corals\Modules\Payment\Bank\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Models\WebhookCall;

class BankWebhookFailed extends WebhookFailed
{
    public static function missingSignature()
    {
        return new static(trans('Bank::exception.request_did_not_contain'));
    }

    public static function invalidSignature($signature)
    {
        return new static(trans('Bank::exception.the_signature_found_header_name',['name' => $signature]));
    }

    public static function signingSecretNotSet()
    {
        return new static(trans('Bank::exception.bank_sign_secret_not_set'));
    }

    public static function invalidBankPayload(WebhookCall $webhookCall)
    {
        return new static(trans('Bank::exception.invalid_bank_payload',['arg' => $webhookCall->id]));
    }

    public static function invalidBankInvoice(WebhookCall $webhookCall)
    {
        return new static(trans('Bank::exception.invalid_bank_invoice_code',['arg' => $webhookCall->id]));
    }

    public static function invalidBankSubscription(WebhookCall $webhookCall)
    {
        return new static(trans('Bank::exception.invalid_bank_subscription',['arg' => $webhookCall->id]));
    }

    public static function invalidBankCustomer(WebhookCall $webhookCall)
    {
        return new static(trans('Bank::exception.invalid_bank_customer',['arg' => $webhookCall->id]));
    }
}