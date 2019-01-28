<?php

namespace Corals\Modules\Advert\Providers;

use Corals\Modules\Advert\Models\Banner;
use Corals\Modules\Advert\Models\Impression;
use Corals\Modules\Advert\Models\Zone;
use Corals\Modules\Advert\Observers\BannerObserver;
use Corals\Modules\Advert\Observers\ImpressionObserver;
use Corals\Modules\Advert\Observers\ZoneObserver;
use Illuminate\Support\ServiceProvider;

class AdvertObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {
        Zone::observe(ZoneObserver::class);
        Banner::observe(BannerObserver::class);
        Impression::observe(ImpressionObserver::class);
    }
}