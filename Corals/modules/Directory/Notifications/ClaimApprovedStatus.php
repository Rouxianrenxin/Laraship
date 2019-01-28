<?php

namespace Corals\Modules\Directory\Notifications;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class ClaimApprovedStatus extends CoralsBaseNotification
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
        $claim = $this->data['claim'];

        return [
            'listing_name' => $claim->listing->name,
            'claim_status' => $claim->status,
            'brief_desctiption' => $claim->brief_desctiption,
            'user_name' => $claim->user->name,
            'listing_link' => url('listings/' . $claim->listing->slug)
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'listing_name' => 'listing name',
            'claim_status' => 'claim status',
            'brief_desctiption' => 'Brief Description',
            'user_name' => 'End User name',
            'listing_link' => 'Listing Link'
        ];
    }
}
