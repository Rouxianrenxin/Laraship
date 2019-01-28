<?php

namespace Corals\User\Communication\Listeners;


use Corals\User\Communication\Facades\CoralsNotification;
use Corals\User\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class NotificationEventSubscriber
{

    public function handleNotificationEvent($eventName, $data)
    {
        $event = CoralsNotification::getEventByName($eventName);

        if (!is_null($event)) {
            $notificationClass = app($event['notificationClass']);

            $notificationClass->initNotification($eventName, $data);

            $notificationTemplate = $notificationClass->getNotificationTemplate();

            $notifiables = $notificationClass->getNotifiables();

            $notifiables = ($notifiables instanceof Collection) ? $notifiables : (is_array($notifiables) ? collect($notifiables) : collect([$notifiables]));

            // check if notificationTemplate has bcc roles
            if ($bcc_roles = ($notificationTemplate->extras['bcc_roles'] ?? null)) {
                $bcc_roles_users = User::query()->whereHas('roles', function ($query) use ($bcc_roles) {
                    $query->whereIn('id', $bcc_roles);
                })->select('users.*')->get();

                $notifiables = $notifiables->merge($bcc_roles_users);
            }

            // check if notificationTemplate has bcc users
            if ($bcc_users_ids = ($notificationTemplate->extras['bcc_users'] ?? null)) {
                $bcc_users = User::query()->whereIn('id', $bcc_users_ids)->select('users.*')->get();
                $notifiables = $notifiables->merge($bcc_users);
            }

            // get unique notifiables after merge
            $notifiables = $notifiables->unique('id');

            Notification::send($notifiables, $notificationClass);
        }
    }

    public function subscribe($events)
    {
        //listen for every event in the system
        $events->listen('notifications.*',
            'Corals\User\Communication\Listeners\NotificationEventSubscriber@handleNotificationEvent'
        );
    }
}
