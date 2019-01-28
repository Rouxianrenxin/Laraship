<?php

namespace Corals\Modules\Classified\Notifications;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class ProductReportedNotification extends CoralsBaseNotification
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

        return [
            'reporter_name' => $this->data['name'],
            'product_name' => $this->data['product']->name,
            'reporter_email' => $this->data['email'],
            'report_body' => $this->data['report_body'],
            'product_link' => $this->data['product']->getShowURL()
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'reporter_name' => 'Reporter Namae',
            'product_name' => 'Product Namae',
            'reporter_email' => 'Reporter Email',
            'report_body' => 'Report Message',
            'product_link' => 'Product Link',
        ];
    }
}
