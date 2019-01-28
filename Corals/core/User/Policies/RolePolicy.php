<?php

namespace Corals\User\Policies;

use Corals\User\Models\User;
use Corals\User\Models\Role;

class RolePolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('User::role.view')) {
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
        return $user->can('User::role.create');
    }

    /**
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function update(User $user, Role $role)
    {
        if ($user->can('User::role.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Role $role
     * @return bool
     */
    public function destroy(User $user, Role $role)
    {
        if ($user->can('User::role.delete')) {
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
        if ($user->hasPermissionTo('Administrations::admin.user')) {
            return true;
        }
        return null;
    }
}
