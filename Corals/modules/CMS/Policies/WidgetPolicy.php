<?php

namespace Corals\Modules\CMS\Policies;

use Corals\User\Models\User;
use Corals\Modules\CMS\Models\Widget;

class WidgetPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('CMS::widget.view')) {
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
        return $user->can('CMS::widget.create');
    }

    /**
     * @param User $user
     * @param Widget $widget
     * @return bool
     */
    public function update(User $user, Widget $widget)
    {
        if ($user->can('CMS::widget.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Widget $widget
     * @return bool
     */
    public function destroy(User $user, Widget $widget)
    {
        if ($user->can('CMS::widget.delete')) {
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
