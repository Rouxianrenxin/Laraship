<?php

namespace Corals\Modules\Classified\Policies;

use Corals\Modules\Classified\Models\Product;
use Corals\User\Models\User;

class ProductPolicy
{

    protected function canManage(User $user)
    {
        return $user->can('Classified::product.manage');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($this->canManage($user)) {
            return true;
        }

        if (request()->is('classified/user*') && $user->can('Classified::product.view')) {
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
        if ($this->canManage($user)) {
            return true;
        }

        return request()->is('classified/user*') && $user->can('Classified::product.create');
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function update(User $user, Product $product)
    {
        if ($this->canManage($user)) {
            return true;
        }

        if (request()->is('classified/user*')
            && $product->user_id == user()->id
            && $user->can('Classified::product.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function destroy(User $user, Product $product)
    {
        if ($this->canManage($user)) {
            return true;
        }

        if (request()->is('classified/user*')
            && $product->user_id == user()->id
            && $user->can('Classified::product.delete')) {
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
        if ($user->hasPermissionTo('Administrations::admin.classified')) {
            return true;
        }

        return null;
    }
}
