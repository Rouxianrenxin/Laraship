<?php

namespace Corals\Modules\Subscriptions\Notifications;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class SubscriptionCreatedNotification extends CoralsBaseNotification
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
        $user = $this->data['user'];
        $subscription = $this->data['subscription'];

        return [
            'user' => $user->full_name,
            'dashboard_link' => url('dashboard'),
            'reference' => $subscription->subscription_reference,
            'created_at' => format_date($subscription->created_at),
            'ends_at' => format_date($subscription->ends_at),
            'plan_name' => $subscription->plan->name,
            'plan_price' => \Payments::currency($subscription->plan->price),
            'plan_frequency' => $subscription->plan->bill_frequency,
            'plan_cycle' => $subscription->plan->bill_cycle,
            'product_name' => $subscription->plan->product->name,
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'user' => 'Subscription user name',
            'dashboard_link' => 'User dashboard Link',
            'reference' => 'Subscription reference',
            'created_at' => 'Subscription created at',
            'ends_at' => 'Subscription ends at',
            'plan_name' => 'Plan name',
            'plan_price' => 'Plan price',
            'plan_frequency' => 'Plan bill frequency',
            'plan_cycle' => 'Plan bill cycle',
            'product_name' => 'Plan product name'
        ];
    }
}
