<?php

namespace Corals\Modules\Utility\Policies;

use Corals\Modules\Utility\Models\Address\Location;
use Corals\User\Models\User;

class LocationPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Utility::location.view')) {
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
        return $user->can('Utility::location.create');
    }

    /**
     * @param User $user
     * @param Location $location
     * @return bool
     */
    public function update(User $user, Location $location)
    {
        if ($user->can('Utility::location.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Location $location
     * @return bool
     */
    public function destroy(User $user, Location $location)
    {
        if ($user->can('Utility::location.delete')) {
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
        if ($user->hasPermissionTo('Administrations::admin.utility')) {
            return true;
        }

        return null;
    }
}
