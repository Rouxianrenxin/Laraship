<?php

namespace Corals\Modules\Subscriptions\Hooks;


use Corals\Modules\Subscriptions\Models\Plan;

Class Subscribable
{


    function check_subscriptions_access()
    {
        return function ($can_access, $mix, $user) {
            $subscribable_classes = $this->is_subscribable(get_class($mix));
            if ($subscribable_classes) {
                $object_subscribable_plans = $mix->subscribable_plans;
                if ($object_subscribable_plans) {
                    foreach ($object_subscribable_plans as $object_subscribable_plan) {
                        if ($user->subscribed(null, $object_subscribable_plan->id)) {
                            return true;
                        }

                    }

                }
            }

            return $can_access;
        };
    }

    /**
     * @return mixed
     */

    protected function subscribable_plans()
    {
        return function ($params = []) {

            $relation = $this->morphToMany(Plan::class, 'subscribable');
            if (isset($params['getData']) && $params['getData']) {
                return $relation->getResults();
            } else {
                return $relation;

            }
        };
    }

}