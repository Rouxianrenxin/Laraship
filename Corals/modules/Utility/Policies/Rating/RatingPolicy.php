<?php

namespace Corals\Modules\Utility\Policies\Rating;

use Corals\User\Models\User;
use Corals\Modules\Utility\Models\Rating\Rating;

class RatingPolicy
{

    public function updateStatus(User $user, Rating $rating, $status)
    {
        if (!$user->can('Utility::rating.set_status')) {
            return false;
        }
        switch ($status) {
            case 'pending':
                return $rating->canBePending();
                break;
            case 'approved':
                return $rating->canBeApproved();
                break;
            case 'disapproved':
                return $rating->canBeDisApproved();
                break;
            case 'spam':
                return $rating->canBeSpam();
                break;
            default:
                return false;
        }
    }

    public function create(User $user)
    {
        return $user->can('Utility::rating.create');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Utility::rating.view')) {
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
