<?php

namespace Corals\Modules\Advert\Policies;

use Corals\User\Models\User;

class ImpressionPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Advert::impression.view')) {
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
        if ($user->hasPermissionTo('Administrations::admin.advertiser')) {
            return true;
        }

        return null;
    }
}
