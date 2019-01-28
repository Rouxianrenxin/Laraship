<?php

namespace Corals\Modules\Directory\Policies;

use Corals\Modules\Directory\Models\Claim;
use Corals\User\Models\User;

class ClaimPolicy
{

    public function updateStatus(User $user, Claim $claim, $status)
    {
        if (!$user->can('Directory::claim.set_status')) {
            return false;
        }

        switch ($status) {
            case 'declined':
                return $claim->canBeDeclined();
                break;
            case 'approved':
                return $claim->canBeApproved();
                break;
            case 'pending':
                return $claim->canBePending();
                break;
            default:
                return false;
        }
    }
    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Directory::claim.view')) {
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
        return $user->can('Directory::claim.create');
    }

    /**
     * @param User $user
     * @param Listing $listing
     * @return bool
     */
    public function update(User $user)
    {
        if ($user->can('Directory::claim.update')) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Listing $listing
     * @return bool
     */
    public function destroy(User $user)
    {
        if ($user->can('Directory::claim.delete')) {
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
        if (isSuperUser($user)) {
            return true;
        }

        return null;
    }
}
