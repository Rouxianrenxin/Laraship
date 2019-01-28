<?php

namespace Corals\User\Communication\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\User\Communication\Models\NotificationTemplate;

class NotificationTemplateTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('notification.models.notification_template.resource_url');

        parent::__construct();
    }

    /**
     * @param NotificationTemplate $notification_template
     * @return array
     * @throws \Throwable
     */
    public function transform(NotificationTemplate $notification_template)
    {
        $excluded_actions = ['delete' => ''];

        return [
            'id' => $notification_template->id,
            'friendly_name' => $notification_template->friendly_name,
            'name' => $notification_template->name,
            'title' => $notification_template->title,
            'body' => json_encode($notification_template->body),
            'extras' => json_encode($notification_template->extras),
            'created_at' => format_date($notification_template->created_at),
            'updated_at' => format_date($notification_template->updated_at),
            'action' => $this->actions($notification_template, $excluded_actions),
        ];
    }
}