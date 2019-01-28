<?php

namespace Corals\Modules\Ecommerce\Notifications;

use Corals\Modules\Ecommerce\Mails\OrderReceivedEmail;
use Corals\User\Communication\Classes\CoralsBaseNotification;

class OrderReceivedNotification extends CoralsBaseNotification
{
    /**
     * @param null $subject
     * @param null $body
     * @return OrderReceivedEmail|null
     */
    protected function mailable($subject = null, $body = null)
    {
        return new OrderReceivedEmail($this->data['user'], $this->data['order'], $subject, $body);
    }

    /**
     * @return mixed
     */
    public function getNotifiables()
    {
        return $this->data['user'];
    }

    public function getNotificationMessageParameters($notifiable, $channel)
    {
        $user = $this->data['user'];

        return [
            'name' => $user->name,
            'my_orders_link' => url(config('ecommerce.models.order.resource_url') . '/my'),
            'order_link' => url(config('ecommerce.models.order.resource_url') . '/' . $this->data['order']->hashed_id)
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'name' => 'Order user name',
            'my_orders_link' => 'User My Orders View Link',
            'order_link' => 'Order view link'
        ];
    }
}
