<?php

namespace Corals\Modules\Slider\Providers;


use Corals\Modules\Slider\Models\Slide;
use Corals\Modules\Slider\Models\Slider;
use Corals\Modules\Slider\Policies\SlidePolicy;
use Corals\Modules\Slider\Policies\SliderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class SliderAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Slider::class => SliderPolicy::class,
        Slide::class => SlidePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}