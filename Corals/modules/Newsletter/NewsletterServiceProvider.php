<?php

namespace Corals\Modules\Newsletter;

use Corals\Modules\Newsletter\Facades\Newsletter;
use Corals\Modules\Newsletter\Models\MailList;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\Modules\Newsletter\Providers\NewsletterAuthServiceProvider;
use Corals\Modules\Newsletter\Providers\NewsletterObserverServiceProvider;
use Corals\Modules\Newsletter\Providers\NewsletterRouteServiceProvider;

use Corals\Modules\Newsletter\Widgets\EmailLoggerByBrowserWidget;
use Corals\Modules\Newsletter\Widgets\EmailLoggerByDeviceTypeWidget;
use Corals\Modules\Newsletter\Widgets\EmailLoggerByPlatformWidget;
use Corals\Modules\Newsletter\Widgets\EmailLoggerByStatusWidget;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Newsletter');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Newsletter');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();
        $this->registerWidgets();

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/newsletter.php', 'newsletter');

        $this->app->register(NewsletterRouteServiceProvider::class);
        $this->app->register(NewsletterAuthServiceProvider::class);
        $this->app->register(NewsletterObserverServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Newsletter', Newsletter::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(MailList::class);
        Settings::addCustomFieldModel(Subscriber::class);
        Settings::addCustomFieldModel(Email::class);
    }


    protected function registerWidgets()
    {
        \Shortcode::addWidget('email_logger_by_status', EmailLoggerByStatusWidget::class);
        \Shortcode::addWidget('email_logger_by_browser', EmailLoggerByBrowserWidget::class);
        \Shortcode::addWidget('email_logger_by_platform', EmailLoggerByPlatformWidget::class);
        \Shortcode::addWidget('email_logger_by_device_type', EmailLoggerByDeviceTypeWidget::class);
    }
}
