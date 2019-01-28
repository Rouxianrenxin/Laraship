<?php

namespace Corals\Modules\Referral\Providers;


use Corals\Modules\Referral\Models\ReferralLink;
use Corals\Modules\Referral\Models\ReferralProgram;
use Corals\Modules\Referral\Observers\ReferralLinkObserver;
use Corals\Modules\Referral\Observers\ReferralProgramObserver;
use Illuminate\Support\ServiceProvider;

class ReferralObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        ReferralProgram::observe(ReferralProgramObserver::class);
        ReferralLink::observe(ReferralLinkObserver::class);
    }
}