<?php

namespace Corals\Modules\LicenceManager\Providers;

use Corals\Modules\LicenceManager\Models\Licence;
use Corals\Modules\LicenceManager\Observers\LicenceObserver;
use Illuminate\Support\ServiceProvider;

class LicenceManagerObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Licence::observe(LicenceObserver::class);
    }
}