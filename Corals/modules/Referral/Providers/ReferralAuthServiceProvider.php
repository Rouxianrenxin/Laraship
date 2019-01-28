<?php

namespace Corals\Modules\Referral\Providers;


use Corals\Modules\Referral\Models\ReferralLink;
use Corals\Modules\Referral\Models\ReferralProgram;
use Corals\Modules\Referral\Policies\ReferralLinkPolicy;
use Corals\Modules\Referral\Policies\ReferralProgramPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ReferralAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ReferralProgram::class => ReferralProgramPolicy::class,
        ReferralLink::class => ReferralLinkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}