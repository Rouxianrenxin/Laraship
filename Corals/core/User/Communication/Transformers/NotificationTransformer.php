<?php

namespace Corals\User\Communication\Transformers;

use Carbon\Carbon;
use Corals\Foundation\Transformers\BaseTransformer;
use Corals\User\Communication\Models\Notification;
use Corals\User\Communication\Models\NotificationTemplate;

class NotificationTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('notification.models.notification.resource_url');

        parent::__construct();
    }

    /**
     * @param Notification $notification
     * @return array
     * @throws \Throwable
     */
    public function transform(Notification $notification)
    {
        $title = $notification->data['title'];

        $title = iconv(mb_detect_encoding($title, mb_detect_order(), true), "UTF-8", $title);
        $title = addslashes($title);
        $title = htmlspecialchars($title, ENT_COMPAT, 'UTF-8');

        $actions = [
            'delete' => '',
            'edit' => '',
            'toggle-read' => [
                'icon' => 'fa fa-fw ' . ($notification->read() ? 'fa-eye-slash' : 'fa-eye'),
                'href' => url($this->resource_url . '/' . $notification->id . '/read-at-toggle/'),
                'label' => $notification->read() ? trans('Notification::labels.mark_as_unread') : trans('Notification::labels.mark_as_read'),
                'data' => [
                    'action' => 'get',
                    'table' => '#NotificationDataTable'
                ]
            ]
        ];

        return [
            'id' => $notification->id,
            'type' => $notification->type,
            'title' => '<a href="' . url($this->resource_url . '/' . $notification->id) . '" class="modal-load" data-title="' . $title . '">' .( $notification->read_at ?   $notification->data['title'] :  "<span style='font-weight:600'>" . $notification->data['title'] . "</span>"). '</a>',
            'body' => $notification->data['body'],
            'created_at' => format_date($notification->created_at),
            'updated_at' => format_date($notification->updated_at),
            'read_at' => $notification->read_at ? (new Carbon($notification->read_at))->format('Y-m-d H:i') : '-',
            'action' => $this->actions($notification, $actions),
        ];
    }
}