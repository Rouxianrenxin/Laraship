<?php

namespace Corals\Modules\Referral\Observers;

use Corals\Modules\Referral\Models\ReferralLink;

class ReferralLinkObserver
{

    /**
     * @param ReferralLink $referral_link
     */
    public function created(ReferralLink $referral_link)
    {
    }
}