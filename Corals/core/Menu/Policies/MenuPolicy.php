<?php

namespace Corals\Menu\Policies;

use Corals\Menu\Models\Menu;
use Corals\User\Models\User;

class MenuPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Menu::menu.view')) {
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
        return $user->can('Menu::menu.create');
    }

    /**
     * @param User $user
     * @param Menu $menu
     * @return bool
     */
    public function update(User $user, Menu $menu)
    {
        if ($user->can('Menu::menu.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Menu $menu
     * @return bool
     */
    public function destroy(User $user, Menu $menu)
    {
        if ($user->can('Menu::menu.delete')) {
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
        if ($user->hasPermissionTo('Administrations::admin.menu')) {
            return true;
        }
        return null;
    }
}
