<?php

namespace Corals\Modules\Utility;

use Corals\User\Communication\Facades\CoralsNotification;
use Corals\Modules\Utility\Facades\Address\Address;
use Corals\Modules\Utility\Facades\Category\Category;
use Corals\Modules\Utility\Facades\Rating\RatingManager;
use Corals\Modules\Utility\Facades\Tag\Tag;
use Corals\Modules\Utility\Facades\Utility;
use Corals\Modules\Utility\Notifications\Rating\RateCreated;
use Corals\Modules\Utility\Notifications\Rating\RatingToggleStatus;
use Corals\Modules\Utility\Models\Address\Location;
use Corals\Modules\Utility\Models\Category\Category as CategoryModel;
use Corals\Modules\Utility\Providers\UtilityAuthServiceProvider;
use Corals\Modules\Utility\Providers\UtilityObserverServiceProvider;
use Corals\Modules\Utility\Providers\UtilityRouteServiceProvider;

use Corals\Settings\Facades\Settings;
use Corals\User\Models\User;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Utility');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Utility');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();

        $this->addEvents();

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/utility.php', 'utility');

        $this->app->register(UtilityRouteServiceProvider::class);
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityObserverServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Utility', Utility::class);
            $loader->alias('Address', Address::class);
            $loader->alias('Category', Category::class);
            $loader->alias('Tag', Tag::class);
            $loader->alias('RatingManager', RatingManager::class);
        });



    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(CategoryModel::class, 'Category (Utility)');
        Settings::addCustomFieldModel(Location::class, 'Location (Utility)');
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.rate.rate_created',
            'Rate Created',
            RateCreated::class);

        CoralsNotification::addEvent(
            'notifications.rate.rate_toggle_status',
            'Rate Toggle Status',
            RatingToggleStatus::class);
    }
}
