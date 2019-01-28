<?php

namespace Corals\Modules\Ecommerce\Notifications;

use Corals\Modules\Ecommerce\Mails\OrderUpdatedEmail;
use Corals\User\Communication\Classes\CoralsBaseNotification;

class OrderUpdatedNotification extends CoralsBaseNotification
{
    /**
     * @param null $subject
     * @param null $body
     * @return OrderUpdatedEmail|null
     */
    protected function mailable($subject = null, $body = null)
    {
        return new OrderUpdatedEmail($this->data['order'], $subject, $body);
    }

    /**
     * @return mixed
     */
    public function getNotifiables()
    {
        $order_buyer = $this->data['order']->user;
        return [$order_buyer];
    }

    public function getNotificationMessageParameters($notifiable, $channel)
    {
        $order = $this->data['order'];
        $user = $order->user;

        return [
            'name' => $user->full_name,
            'order_link' => url(config('ecommerce.models.order.resource_url') . '/' . $order->hashed_id),
            'order_number' => $order->order_number
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'name' => 'Order user name',
            'order_number' => 'order Number',
            'order_link' => 'Order view link'
        ];
    }
}
