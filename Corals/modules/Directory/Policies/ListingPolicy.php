<?php

namespace Corals\Modules\Directory\Policies;

use Corals\Modules\Directory\Models\Listing;
use Corals\User\Models\User;

class ListingPolicy
{
    public function admin(User $user)
    {
        return $user->can('Administrations::admin.directory');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($this->admin($user)) {
            return true;
        }
        if (request()->is('directory/user*') && $user->can('Directory::listing.view')) {
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
        if ($this->admin($user)) {
            return true;
        }
        return request()->is('directory/user*') && $user->can('Directory::listing.create');

    }

    /**
     * @param User $user
     * @param Listing $listing
     * @return bool
     */
    public function update(User $user, Listing $listing)
    {
        if ($this->admin($user)) {
            return true;
        }
        if (request()->is('directory/user*')
            && $listing->user_id == user()->id
            && $user->can('Directory::listing.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Listing $listing
     * @return bool
     */
    public function destroy(User $user, Listing $listing)
    {
        if ($this->admin($user)) {
            return true;
        }
        if (request()->is('directory/user*')
            && $listing->user_id == user()->id
            && $user->can('Directory::listing.delete')) {
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
        if (isSuperUser($user) || $this->admin($user)) {
            return true;
        }

        return null;
    }
}
