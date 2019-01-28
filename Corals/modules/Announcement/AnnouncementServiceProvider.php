<?php

namespace Corals\Modules\Announcement;

use Corals\Modules\Announcement\Facades\Announcement;
use Corals\Modules\Announcement\Models\Announcement as AnnouncementModel;
use Corals\Modules\Announcement\Providers\AnnouncementAuthServiceProvider;
use Corals\Modules\Announcement\Providers\AnnouncementEventServiceProvider;
use Corals\Modules\Announcement\Providers\AnnouncementObserverServiceProvider;
use Corals\Modules\Announcement\Providers\AnnouncementRouteServiceProvider;

use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AnnouncementServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Announcement');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Announcement');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();

        \Assets::add(asset('assets/modules/announcement/plugins/magnific-popup/jquery.magnific-popup.min.js'));
        \Assets::add(asset('assets/modules/announcement/plugins/magnific-popup/magnific-popup.css'));

        \Assets::add(asset('assets/modules/announcement/js/ann-scripts.js'));
        \Assets::add(asset('assets/modules/announcement/css/ann-style.css'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/announcement.php', 'announcement');

        $this->app->register(AnnouncementRouteServiceProvider::class);
        $this->app->register(AnnouncementAuthServiceProvider::class);
        $this->app->register(AnnouncementObserverServiceProvider::class);
//        $this->app->register(AnnouncementEventServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Announcement', Announcement::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(AnnouncementModel::class);
    }
}
