<?php

namespace Corals\Modules\Utility\Policies\Wishlist;

use Corals\User\Models\User;

class WishlistPolicy
{
    public function create(User $user)
    {
        return $user->can('Utility::rating.create');
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
