<?php

namespace Corals\Modules\Utility\Policies\Category;

use Corals\Modules\Utility\Models\Category\Attribute;
use Corals\User\Models\User;

class AttributePolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Utility::attribute.view')) {
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
        return $user->can('Utility::attribute.create');
    }

    /**
     * @param User $user
     * @param Attribute $attribute
     * @return bool
     */
    public function update(User $user, Attribute $attribute)
    {
        if ($user->can('Utility::attribute.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Attribute $attribute
     * @return bool
     */
    public function destroy(User $user, Attribute $attribute)
    {
        if ($user->can('Utility::attribute.delete')) {
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
