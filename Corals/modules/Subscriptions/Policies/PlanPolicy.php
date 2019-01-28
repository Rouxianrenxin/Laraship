<?php

namespace Corals\Modules\Subscriptions\Policies;

use Corals\User\Models\User;
use Corals\Modules\Subscriptions\Models\Plan;

class PlanPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Subscriptions::plan.view')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('Subscriptions::plan.create');
    }

    /**
     * @param User $user
     * @param Plan $plan
     * @return bool
     */
    public function update(User $user, Plan $plan)
    {
        if ($user->can('Subscriptions::plan.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Plan $plan
     * @return bool
     */
    public function destroy(User $user, Plan $plan)
    {
        if ($user->can('Subscriptions::plan.delete')) {
            return true;
        }
        return false;
    }


    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->hasPermissionTo('Administrations::admin.subscription')) {
            return true;
        }

        return null;
    }
}
