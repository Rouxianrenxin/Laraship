<?php

namespace Corals\Modules\Amazon\Providers;

use Corals\Modules\Amazon\Models\Import;
use Corals\Modules\Amazon\Observers\ImportObserver;
use Illuminate\Support\ServiceProvider;

class AmazonObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Import::observe(ImportObserver::class);
    }
}