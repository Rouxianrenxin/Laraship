<?php

namespace Corals\Modules\Slider\Providers;


use Corals\Modules\Slider\Models\Slide;
use Corals\Modules\Slider\Models\Slider;
use Corals\Modules\Slider\Observers\SlideObserver;
use Corals\Modules\Slider\Observers\SliderObserver;
use Illuminate\Support\ServiceProvider;

class SliderObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Slider::observe(SliderObserver::class);
        Slide::observe(SlideObserver::class);
    }
}