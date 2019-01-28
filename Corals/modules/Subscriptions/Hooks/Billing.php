<?php

namespace Corals\Modules\Subscriptions\Hooks;


use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Subscriptions\Classes\Subscription as SubscriptionClass;

Class Billing
{
    /**
     * Determine if the user has role needs subscription.
     * @return \Closure
     */
    public function subscriptionRequired()
    {
        return function () {
            if (!\Modules::isModuleActive('corals-subscriptions')) {
                return false;
            }
            $roles = $this->roles;

            foreach ($roles as $role) {
                if ($role->subscription_required) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * Determine if the user has a given subscription.
     * to check if subscribed on
     * plan level
     * product level
     * just subscribed
     * @param null $product_id
     * @param null $plan_id
     */
    public function subscribed()
    {
        return function ($product_id = null, $plan_id = null) {
            if (!is_null($product_id)) {
                $subscriptions = $this->getSubscriptionsByProduct($product_id);
            } elseif (!is_null($plan_id)) {
                $subscriptions = $this->getSubscriptionsByPlan($plan_id);
            } else {
                $subscriptions = $this->subscriptions;
            }

            foreach ($subscriptions as $subscription) {
                if ($subscription->valid()) {
                    return true;
                }
            }

            return false;
        };
    }

    protected function getSubscriptionsByProduct()
    {
        return function ($product_id) {
            $subscriptions = $this->subscriptions()->whereHas('plan', function ($plan) use ($product_id) {
                return $plan->where('product_id', $product_id);
            });
            return $subscriptions->get();
        };

    }

    protected function getSubscriptionsByPlan()
    {
        return function ($plan_id) {
            $subscriptions = $this->subscriptions()->where('plan_id', $plan_id)->get();
            return $subscriptions;
        };
    }

    /**
     * get current user subscription
     * @param null $product_id
     * @param null $plan_id
     * @return null
     */
    public function currentSubscription()
    {
        return function ($product_id = null, $plan_id = null) {
            $subscriptions = [];

            if (!is_null($product_id)) {
                $subscriptions = $this->getSubscriptionsByProduct($product_id);
            } elseif (!is_null($plan_id)) {
                $subscriptions = $this->getSubscriptionsByPlan($plan_id);
            }
            foreach ($subscriptions as $subscription) {
                if ($subscription->valid()) {
                    return $subscription;
                }
            }

            return null;

        };

    }

    public function activeSubscriptions()
    {
        return function () {
            $subscriptions = $this->subscriptions;

            return $subscriptions->filter(function ($subscription) {
                return $subscription->active();
            });
        };
    }

    public function pendingSubscriptions()
    {
        return function () {
            return $this->subscriptions()->pending()->get();


        };


    }

    public function canUpdatePaymentDetails()
    {
        return function () {
            if (!$this->gateway) {
                return false;
            }
            if (!\Payments::isGatewaySupported($this->gateway)) {
                return false;
            }

            $subscriptions = new SubscriptionClass($this->gateway);
            if (!$subscriptions->gateway) {
                return false;
            }
            return $subscriptions->gateway->getConfig('can_update_payment');
        };
    }

    /**
     * @return mixed
     */
    public function subscriptions()
    {
        return function ($params = []) {

            $relation = $this->hasMany(Subscription::class, 'user_id')->orderBy('created_at', 'desc');
            if (isset($params['getData']) && $params['getData']) {
                return $relation->getResults();
            } else {
                return $relation;

            }
        };
    }


}
