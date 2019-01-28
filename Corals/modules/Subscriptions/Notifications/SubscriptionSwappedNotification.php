<?php

namespace Corals\Modules\Subscriptions\Notifications;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class SubscriptionSwappedNotification extends CoralsBaseNotification
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
        $old_subscription = $this->data['old_subscription'];

        return [
            'user' => $user->full_name,
            'dashboard_link' => url('dashboard'),
            'reference' => $subscription->subscription_reference,
            'created_at' => format_date($subscription->created_at),
            'ends_at' => format_date($subscription->ends_at),
            'old_reference' => $old_subscription->subscription_reference,
            'old_created_at' => format_date($old_subscription->created_at),
            'old_ends_at' => format_date($old_subscription->ends_at),
            'plan_name' => $subscription->plan->name,
            'plan_price' => \Payments::currency($subscription->plan->price),
            'plan_frequency' => $subscription->plan->bill_frequency,
            'plan_cycle' => $subscription->plan->bill_cycle,
            'product_name' => $subscription->plan->product->name,
            'old_plan_name' => $old_subscription->plan->name,
            'old_plan_price' => \Payments::currency($old_subscription->plan->price),
            'old_plan_frequency' => $old_subscription->plan->bill_frequency,
            'old_plan_cycle' => $old_subscription->plan->bill_cycle,
            'old_product_name' => $old_subscription->plan->product->name,
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
            'old_reference' => 'Old Subscription reference',
            'old_created_at' => 'Old Subscription created at',
            'old_ends_at' => 'Old Subscription ends at',
            'plan_name' => 'Plan name',
            'plan_price' => 'Plan price',
            'plan_frequency' => 'Plan bill frequency',
            'plan_cycle' => 'Plan bill cycle',
            'product_name' => 'Plan product name',
            'old_plan_name' => 'Old Plan name',
            'old_plan_price' => 'Old Plan price',
            'old_plan_frequency' => 'Old Plan bill frequency',
            'old_plan_cycle' => 'Old Plan bill cycle',
            'old_product_name' => 'Old Plan product name'
        ];
    }
}
