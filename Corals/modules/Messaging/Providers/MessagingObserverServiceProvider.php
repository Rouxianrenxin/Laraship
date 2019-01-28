<?php

namespace Corals\Modules\Messaging\Providers;

use Corals\Modules\Messaging\Models\Discussion;
use Corals\Modules\Messaging\Observers\DiscussionObserver;
use Illuminate\Support\ServiceProvider;

class MessagingObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        Discussion::observe(DiscussionObserver::class);
    }
}
