<?php

namespace Corals\Settings\Policies;

use Corals\Settings\Models\Module;
use Corals\User\Models\User;

class ModulePolicy
{
    /**
     * @param User $user
     * @param Module|null $module
     * @return bool
     */
    public function manage(User $user, Module $module = null)
    {
        if ($user->can('Settings::module.manage')) {
            return true;
        }
        return false;
    }

    /**
     * @param $user
     * @param $ability
     * @return bool|null
     */
    public function before($user, $ability)
    {
        if ($user->hasPermissionTo('Administrations::admin.setting')) {
            return true;
        }
        return null;
    }
}
