<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Newsletter\Models\EmailLogger;

class EmailLoggerTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('newsletter.models.email_logger.resource_url');

        parent::__construct();
    }

    /**
     * @param EmailLogger $emailLogger
     * @return array
     * @throws \Throwable
     */
    public function transform(EmailLogger $emailLogger)
    {
        $actions = ['edit' => ''];

        if (in_array($emailLogger->status, ['failed', 'draft'])) {
            $actions['send_email'] = [
                'icon' => 'fa fa-envelope fa-fw',
                'href' => url($this->resource_url . '/' . $emailLogger->hashed_id . '/send-email'),
                'label' => trans('Newsletter::labels.send_email'),
                'data' => [
                    'action' => 'post',
                    'table' => '.dataTableBuilder',
                ]
            ];
        }


        return [
            'id' => $emailLogger->id,
            'subject' => '<a href="' . $emailLogger->getShowURL() . '">' . str_limit($emailLogger->email->subject, 50) . '</a>',
            'subscriber_name' => $emailLogger->subscriber->name ?? '-',
            'subscriber_email' => $emailLogger->subscriber->email,
            'status' => formatStatusAsLabels($emailLogger->status, [
                'text' => trans('Newsletter::attributes.email_logger.status_options.' . $emailLogger->status),
                'level' => config('newsletter.models.email_logger.status_level.' . $emailLogger->status)
            ]),
            'created_at' => format_date($emailLogger->email->created_at),
            'updated_at' => format_date($emailLogger->email->updated_at),
            'action' => $this->actions($emailLogger, $actions)
        ];
    }
}