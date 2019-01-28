<?php

namespace Corals\Modules\Advert;

use Corals\Modules\Advert\Facades\Advert;
use Corals\Modules\Advert\Models\Advertiser;
use Corals\Modules\Advert\Models\Banner;
use Corals\Modules\Advert\Models\Zone;
use Corals\Modules\Advert\Providers\AdvertAuthServiceProvider;
use Corals\Modules\Advert\Providers\AdvertObserverServiceProvider;
use Corals\Modules\Advert\Providers\AdvertRouteServiceProvider;

use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AdvertServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Advert');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Advert');

        // Load migrations
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->registerShortcode();

        $this->registerCustomFieldsModels();

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/advert.php', 'advert');

        $this->app->register(AdvertRouteServiceProvider::class);
        $this->app->register(AdvertAuthServiceProvider::class);
        $this->app->register(AdvertObserverServiceProvider::class);


        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Advert', Advert::class);
        });
    }

    public function registerShortcode()
    {
        \Shortcode::add('zone', function ($key) {
            $view = 'Advert::zones.render';

            if ($key == '$zone') {
                //Assume Zone Object passed
                return "<?php  echo \$__env->make('$view',['zone'=>{$key}])->render(); ?>";
            } else {
                $zone = Zone::where('key', $key)->active()->first();
                $render = view()->make($view)->with(['zone' => $zone, 'zone_key' => $key])->render();
                return $render;
            }

//            if (view()->exists($view)) {
            /*                return "<?php  echo \$__env->make('$view')->render(); ?>";*/
//            }
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Advertiser::class);
        Settings::addCustomFieldModel(Banner::class);
        Settings::addCustomFieldModel(Zone::class);
    }
}
