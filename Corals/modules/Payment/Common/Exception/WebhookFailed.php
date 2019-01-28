<?php

namespace Corals\Modules\Payment\Common\Exception;

use Corals\Modules\Payment\Models\WebhookCall;
use Exception;

class WebhookFailed extends Exception
{
    public static function invalidEventName(WebhookCall $webhookCall)
    {
        return new static(trans('Payment::exception.webhook.invalid_event_name', ['name' => $webhookCall->id, 'eventname' => $webhookCall->eventname]));
    }

    public static function missingEventName(WebhookCall $webhookCall)
    {
        return new static(trans('Payment::exception.webhook.missing_event_name', ['arg' => $webhookCall->id]));
    }

    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }

    public static function processedCall(WebhookCall $webhookCall)
    {
        return new static(trans('Payment::exception.webhook.webhook_already_mark_as_process', ['arg' => $webhookCall->id]));
    }
}