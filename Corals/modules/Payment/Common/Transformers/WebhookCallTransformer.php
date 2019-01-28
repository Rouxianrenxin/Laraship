<?php

namespace Corals\Modules\Payment\Common\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Payment\Models\WebhookCall;

class webhookCallTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.models.webhook_call.resource_url');

        parent::__construct();
    }

    /**
     * @param WebhookCall $webhookCall
     * @return array
     * @throws \Throwable
     */
    public function transform(WebhookCall $webhookCall)
    {
        $actions = ['edit' => '', 'delete' => ''];
        if (!$webhookCall->processed) {
            $actions['process'] = [
                'icon' => 'fa fa-fw fa-send',
                'href' => url($this->resource_url . '/' . $webhookCall->hashed_id . '/process'),
                'label' => trans('Payment::attributes.webhook_call.process'),
                'data' => [
                    'action' => 'post',
                    'table' => '.dataTableBuilder'
                ]
            ];
        }
        return [
            'id' => $webhookCall->id,
            'checkbox' => $this->generateCheckboxElement($webhookCall),
            'event_name' => $webhookCall->event_name,
            'payload' => generatePopover("'" . $webhookCall->getOriginal('payload') . "'"),
            'exception' => $webhookCall->exception ? generatePopover("'" . $webhookCall->getOriginal('exception') . "'") : '-',
            'gateway' => $webhookCall->gateway,
            'processed' => $webhookCall->processed ? '<i class="fa fa-check text-success"></i>' : '-',
            'created_at' => format_date($webhookCall->created_at),
            'updated_at' => format_date($webhookCall->updated_at),
            'action' => $this->actions($webhookCall, $actions)
        ];
    }
}