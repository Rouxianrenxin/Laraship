<?php

namespace Corals\Modules\Messaging;

use Corals\Modules\Messaging\Models\Discussion;
use Corals\Modules\Messaging\Models\Message;
use Corals\Modules\Messaging\Models\Participation;
use Corals\Modules\Messaging\Providers\MessagingAuthServiceProvider;
use Corals\Modules\Messaging\Providers\MessagingObserverServiceProvider;
use Corals\Modules\Messaging\Providers\MessagingRouteServiceProvider;

use Corals\Settings\Facades\Settings;
use Corals\User\Models\User;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Messaging');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Messaging');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerCustomFieldsModels();

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/messaging.php', 'messaging');

        $this->app->register(MessagingRouteServiceProvider::class);
        $this->app->register(MessagingAuthServiceProvider::class);
        $this->app->register(MessagingObserverServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Discussion', Discussion::class);
            $loader->alias('Message', Message::class);
            $loader->alias('Participation', Participation::class);
        });

        $this->bindModels();

        $messagable = new \Corals\Modules\Messaging\Hooks\Messagable();
        User::mixin($messagable);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Discussion::class);
        Settings::addCustomFieldModel(Message::class);
        Settings::addCustomFieldModel(Participation::class);
    }

    /**
     * Bind the models.
     */
    private function bindModels()
    {
        $this->app->bind(Contracts\Discussion::class, Discussion::class);
        $this->app->bind(Contracts\Message::class, Message::class);
        $this->app->bind(Contracts\Participant::class, Participation::class);
    }
}
