<?php

namespace Corals\Activity;

use Corals\Activity\Providers\ActivityAuthServiceProvider;
use Corals\Activity\Providers\ActivityRouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class ActivityServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Activity');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Activity');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/activity.php', 'activity');

        $this->app->register(ActivityRouteServiceProvider::class);
        $this->app->register(ActivityAuthServiceProvider::class);
    }
}
