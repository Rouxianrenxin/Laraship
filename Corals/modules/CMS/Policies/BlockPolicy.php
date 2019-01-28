<?php

namespace Corals\Modules\CMS\Policies;

use Corals\User\Models\User;
use Corals\Modules\CMS\Models\Block;

class BlockPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('CMS::block.view')) {
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
        if ($user->hasPermissionTo('Administrations::admin.cms')) {
            return true;
        }

        return null;
    }
}
