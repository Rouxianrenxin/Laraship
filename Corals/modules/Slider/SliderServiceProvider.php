<?php

namespace Corals\Modules\Slider;

use Corals\Modules\Slider\Models\Slide;
use Corals\Modules\Slider\Models\Slider;
use Corals\Modules\Slider\Providers\SliderAuthServiceProvider;
use Corals\Modules\Slider\Providers\SliderObserverServiceProvider;
use Corals\Modules\Slider\Providers\SliderRouteServiceProvider;

use Corals\Settings\Facades\Settings;
use Illuminate\Support\ServiceProvider;

class SliderServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Slider');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Slider');

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
        $this->mergeConfigFrom(__DIR__ . '/config/slider.php', 'slider');

        $this->app->register(SliderRouteServiceProvider::class);
        $this->app->register(SliderAuthServiceProvider::class);
        $this->app->register(SliderObserverServiceProvider::class);

    }

    public function registerShortcode()
    {
        \Shortcode::add('slider', function ($key) {
            $view = 'Slider::sliders.slider';

            \Assets::add(asset('assets/corals/plugins/OwlCarousel2-2.2.1/owl.carousel.min.js'));
            \Assets::add(asset('assets/corals/plugins/OwlCarousel2-2.2.1/assets/owl.carousel.min.css'));
            \Assets::add(asset('assets/corals/plugins/OwlCarousel2-2.2.1/assets/owl.theme.default.min.css'));

            if ($key == '$slider') {
                //Assume Slider Object passed
                return "<?php  echo \$__env->make('$view',['slider'=>{$key}])->render(); ?>";
            } else {
                $slider = Slider::where('key', $key)->active()->first();

                view()->share(['slider' => $slider, 'slider_key' => $key]);
            }
            if (view()->exists($view)) {
                return "<?php  echo \$__env->make('$view')->render(); ?>";
            }
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Slider::class);
        Settings::addCustomFieldModel(Slide::class);
    }
}
