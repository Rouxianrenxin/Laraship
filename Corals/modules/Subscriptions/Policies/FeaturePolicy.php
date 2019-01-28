<?php

namespace Corals\Modules\Subscriptions\Policies;

use Corals\User\Models\User;
use Corals\Modules\Subscriptions\Models\Feature;

class FeaturePolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Subscriptions::feature.view')) {
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
        return $user->can('Subscriptions::feature.create');
    }

    /**
     * @param User $user
     * @param Feature $feature
     * @return bool
     */
    public function update(User $user, Feature $feature)
    {
        if ($user->can('Subscriptions::feature.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Feature $feature
     * @return bool
     */
    public function destroy(User $user, Feature $feature)
    {
        if ($user->can('Subscriptions::feature.delete')) {
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
