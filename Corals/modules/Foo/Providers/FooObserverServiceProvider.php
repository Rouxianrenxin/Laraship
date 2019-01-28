<?php

namespace Corals\Modules\Foo\Providers;

use Corals\Modules\Foo\Models\Bar;
use Corals\Modules\Foo\Observers\BarObserver;
use Illuminate\Support\ServiceProvider;

class FooObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Bar::observe(BarObserver::class);
    }
}
