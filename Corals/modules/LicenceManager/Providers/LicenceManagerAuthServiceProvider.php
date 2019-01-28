<?php

namespace Corals\Modules\LicenceManager\Providers;

use Corals\Modules\LicenceManager\Models\Licence;
use Corals\Modules\LicenceManager\Policies\LicencePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class LicenceManagerAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Licence::class => LicencePolicy::class,
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