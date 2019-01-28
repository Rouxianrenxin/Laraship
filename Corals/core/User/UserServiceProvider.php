<?php

namespace Corals\User;

use Corals\User\Communication\CommunicationServiceProvider;
use Corals\User\Communication\Facades\CoralsNotification;
use Corals\Settings\Facades\Settings;
use Corals\User\Classes\TwoFactorAuth;
use Corals\User\Facades\Users;
use Corals\User\Hooks\Users as UserHooks;
use Corals\User\Models\Role;
use Corals\User\Models\User;
use Corals\User\Notifications\UserConfirmationNotification;
use Corals\User\Notifications\UserRegisteredNotification;
use Corals\User\Providers\UserAuthServiceProvider;
use Corals\User\Providers\UserEventServiceProvider;
use Corals\User\Providers\UserObserverServiceProvider;
use Corals\User\Providers\UserRouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'User');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'User');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->registerWidgets();

        $this->registerCustomFieldsModels();
        $this->addEvents();
        $this->registerHooks();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configFilesPath = __DIR__ . '/config';

        $configFiles = \File::allFiles($configFilesPath);

        foreach ($configFiles as $file) {
            $config = $file->getBasename('.php');

            $this->mergeConfigFrom($configFilesPath . '/' . $file->getBasename(), $config);
        }

        $this->app->register(UserRouteServiceProvider::class);
        $this->app->register(UserAuthServiceProvider::class);
        $this->app->register(UserObserverServiceProvider::class);
        $this->app->register(UserEventServiceProvider::class);
        $this->app->register(CommunicationServiceProvider::class);


        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Users', Users::class);

        });

        $this->app->singleton('TwoFactorAuth', function () {

            $is_two_factor_auth_enabled = \Settings::get('two_factor_auth_enabled', false);

            $providerKey = \Settings::get('two_factor_auth_provider');

            $providerKey = ucfirst($providerKey);

            if ($is_two_factor_auth_enabled && class_exists("Corals\User\Services\\$providerKey")) {
                $provider = app("Corals\User\Services\\$providerKey");
            } else {
                $provider = null;
            }

            return new TwoFactorAuth($provider);
        });

        $this->app['router']->pushMiddlewareToGroup('web', \Corals\User\Middleware\CookieConsentMiddleware::class);

    }

    public function registerWidgets()
    {
        \Shortcode::addWidget('new_users', \Corals\User\Widgets\NewUsersWidget::class);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(User::class);
        Settings::addCustomFieldModel(Role::class);
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.user.registered',
            'New user registration',
            UserRegisteredNotification::class);

        CoralsNotification::addEvent(
            'notifications.user.confirmation',
            'New user confirmation',
            UserConfirmationNotification::class);
    }

    protected function registerHooks()
    {

        \Actions::add_action('footer_js', [UserHooks::class, 'add_cookie_consent'], 12);
        \Actions::add_action('admin_footer_js', [UserHooks::class, 'add_cookie_consent'], 12);


    }
}
