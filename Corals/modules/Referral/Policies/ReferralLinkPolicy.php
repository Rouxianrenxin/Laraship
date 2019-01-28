<?php

namespace Corals\Modules\Referral\Policies;

use Corals\Modules\Referral\Models\ReferralLink;
use Corals\User\Models\User;

class ReferralLinkPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Referral::referral_link.view')) {
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
        return $user->can('Referral::referral_link.create');
    }

    /**
     * @param User $user
     * @param Referral $referral_link
     * @return bool
     */
    public function update(User $user, ReferralLink $referral_link)
    {
        if ($user->can('Referral::referral_link.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Referral $referral_link
     * @return bool
     */
    public function destroy(User $user, ReferralLink $referral_link)
    {
        if ($user->can('Referral::referral_link.delete')) {
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
