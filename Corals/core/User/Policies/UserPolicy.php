<?php

namespace Corals\User\Policies;

use Corals\User\Models\User;
use Corals\User\Models\User as UserModel;

class UserPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('User::user.view')) {
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
        return $user->can('User::user.create');
    }

    /**
     * @param User $user
     * @param UserModel $usermodel
     * @return bool
     */
    public function update(User $user, UserModel $usermodel)
    {
        if ($user->can('User::user.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param UserModel $usermodel
     * @return bool
     */
    public function destroy(User $user, UserModel $usermodel)
    {
        if ($user->can('User::user.delete')) {
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
