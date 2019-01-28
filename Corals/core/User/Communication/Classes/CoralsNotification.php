<?php

namespace Corals\User\Communication\Classes;


use Carbon\Carbon;
use Corals\User\Communication\Models\NotificationTemplate;
use Corals\User\Models\User;

class CoralsNotification
{
    public $events = [];

    /**
     * Notification constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $name
     * @param $friendlyName
     * @param $notificationClass
     * @param string $title
     * @param array $body
     */
    public function addEvent($name, $friendlyName, $notificationClass, $title = '', $body = [])
    {
        $this->events[$name] = [
            'notificationClass' => $notificationClass,
            'friendly_name' => $friendlyName,
            'title' => $title,
            'body' => json_encode($body)
        ];
    }

    public function getEventsList()
    {
        return $this->events;
    }

    public function getEventByName($name)
    {
        return $this->getEventsList()[$name] ?? null;
    }

    public function insertNewEventsToDatabase()
    {
        $eventsNamesInDatabase = NotificationTemplate::pluck('name')->toArray();

        $allEventsNames = array_keys($this->getEventsList());

        $newEventsNames = array_diff($allEventsNames, $eventsNamesInDatabase);

        $newEventsNames = array_map(function ($name) {
            $event = $this->getEventByName($name);
            return [
                'name' => $name,
                'friendly_name' => $event['friendly_name'],
                'title' => $event['title'],
                'body' => $event['body'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }, $newEventsNames);

        NotificationTemplate::query()->insert($newEventsNames);
    }

    /*
     * @return array
     * function to return the notification parameters and there description for a given template
     */
    public function getNotificationParametersDescription(NotificationTemplate $notificationTemplate)
    {
        return $this->getEventByName($notificationTemplate->name)['notificationClass']::getNotificationMessageParametersDescriptions();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getUserNotificationTemplates(User $user)
    {
        return NotificationTemplate::whereHas('roles', function ($query) use ($user) {
            $query->whereIn('role_id', $user->roles()->pluck('id'));
        })->where('via', 'like', '%user_preferences%')->get();
    }
}
