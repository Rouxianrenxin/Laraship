<?php

namespace Corals\Modules\Classified;

use Corals\Modules\Classified\Facades\Classified;
use Corals\Modules\Classified\Models\Product;
use Corals\Modules\Classified\Notifications\ProductReportedNotification;
use Corals\Modules\Classified\Providers\ClassifiedAuthServiceProvider;
use Corals\Modules\Classified\Providers\ClassifiedObserverServiceProvider;
use Corals\Modules\Classified\Providers\ClassifiedRouteServiceProvider;
use Corals\Modules\Classified\Hooks\Classified as ClassifiedHook;

use Corals\Modules\Utility\Facades\Utility;
use Corals\Settings\Facades\Settings;
use Corals\User\Communication\Facades\CoralsNotification;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ClassifiedServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Classified');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Classified');

        $this->registerCustomFieldsModels();

        $this->addEvents();


        \Filters::add_filter('auth_theme', [ClassifiedHook::class, 'auth_theme'], 100);
        \Filters::add_filter('auth_redirect_to', [ClassifiedHook::class, 'auth_redirect_to'], 100);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/classified.php', 'classified');

        $this->app->register(ClassifiedRouteServiceProvider::class);
        $this->app->register(ClassifiedAuthServiceProvider::class);
        $this->app->register(ClassifiedObserverServiceProvider::class);
        //register Settings alias instead of adding it to config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Classified', Classified::class);
        });

        Utility::addToUtilityModules('Classified');
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Category::class, 'Category (Classified)');
        Settings::addCustomFieldModel(Product::class, 'Product (Classified)');
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.classified.product.reported',
            'Classified Product Reported',
            ProductReportedNotification::class);
    }
}
