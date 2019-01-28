<?php

namespace Corals\Modules\Referral\Observers;

use Corals\Modules\Referral\Models\ReferralProgram;

class ReferralProgramObserver
{

    /**
     * @param ReferralProgram $referral_program
     */
    public function created(ReferralProgram $referral_program)
    {
    }
}