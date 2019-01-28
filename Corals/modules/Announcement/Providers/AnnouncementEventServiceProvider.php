<?php

namespace Corals\Modules\Announcement\Providers;

use Corals\Modules\Announcement\Listeners\ShowOnLoginAnnouncements;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AnnouncementEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            ShowOnLoginAnnouncements::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];
}
