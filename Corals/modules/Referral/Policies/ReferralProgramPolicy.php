<?php

namespace Corals\Modules\Referral\Policies;

use Corals\User\Models\User;
use Corals\Modules\Referral\Models\ReferralProgram;

class ReferralProgramPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Referral::referral_program.view')) {
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
        return $user->can('Referral::referral_program.create');
    }

    /**
     * @param User $user
     * @param Referral $referral_program
     * @return bool
     */
    public function update(User $user, ReferralProgram $referral_program)
    {
        if ($user->can('Referral::referral_program.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Referral $referral_program
     * @return bool
     */
    public function destroy(User $user, ReferralProgram $referral_program)
    {
        if ($user->can('Referral::referral_program.delete')) {
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
