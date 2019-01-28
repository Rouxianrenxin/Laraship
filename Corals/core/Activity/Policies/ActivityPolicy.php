<?php

namespace Corals\Activity\Policies;

use Corals\User\Models\User;
use Corals\Activity\Models\Activity;

class ActivityPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Activity::activity.view')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function destroy(User $user, Activity $activity)
    {
        if ($user->can('Activity::activity.delete')) {
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
        if ($user->hasPermissionTo('Administrations::admin.activity')) {
            return true;
        }
        return null;
    }
}
