<?php

namespace Corals\Modules\Directory\Notifications;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class ListingClaim extends CoralsBaseNotification
{
    /**
     * @return mixed
     */
    public function getNotifiables()
    {
        return [];
    }

    public function getNotificationMessageParameters($notifiable, $channel)
    {

        $listing = $this->data['listing'];
        $user = $this->data['user'];
        $claim = $this->data['claim'];

        return [
            'listing_name' => $listing->name,
            'brief_desctiption' => $claim->brief_desctiption,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'listing_name' => 'listing name',
            'brief_desctiption' => 'Brief Description',
            'user_name' => 'End User name',
            'user_email' => 'End User email',
        ];
    }
}
