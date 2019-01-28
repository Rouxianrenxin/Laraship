<?php

namespace Corals\Modules\Directory\Notifications;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class ListingCreated extends CoralsBaseNotification
{
    /**
     * @return mixed
     */
    public function getNotifiables()
    {
        return $this->data['user'];
    }

    public function getNotificationMessageParameters($notifiable, $channel)
    {
        $listing = $this->data['listing'];
        $user = $this->data['user'];

        return [
            'listing_name' => $listing->name,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'listing_link' => url('listings/' . $listing->slug)
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'listing_name' => 'listing name',
            'user_name' => 'End User name',
            'user_email' => 'End User email',
            'listing_link' => 'Listing Link'
        ];
    }
}
