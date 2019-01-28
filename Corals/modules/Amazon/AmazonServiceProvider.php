<?php

namespace Corals\Modules\Amazon;

use Corals\Modules\Amazon\Console\Commands\RunImports;
use Corals\Modules\Amazon\Facades\Amazon;
use Corals\Modules\Amazon\Models\Import as Import;
use Corals\Modules\Amazon\Providers\AmazonAuthServiceProvider;
use Corals\Modules\Amazon\Providers\AmazonObserverServiceProvider;
use Corals\Modules\Amazon\Providers\AmazonRouteServiceProvider;

use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AmazonServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */

    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Amazon');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Amazon');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();
        $this->registerCommand();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/amazon.php', 'amazon');

        $this->app->register(AmazonRouteServiceProvider::class);
        $this->app->register(AmazonAuthServiceProvider::class);
        $this->app->register(AmazonObserverServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Amazon', Amazon::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Import::class);
    }

    protected function registerCommand()
    {
        $this->commands(RunImports::class);
    }

}
