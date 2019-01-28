<?php

namespace Corals\Modules\Announcement\Providers;

use Corals\Modules\Announcement\Models\Announcement;
use Corals\Modules\Announcement\Observers\AnnouncementObserver;
use Illuminate\Support\ServiceProvider;

class AnnouncementObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Announcement::observe(AnnouncementObserver::class);
    }
}