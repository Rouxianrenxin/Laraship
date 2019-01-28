<?php

namespace Corals\Modules\Newsletter\Providers;

use Corals\Modules\Newsletter\Models\MailList;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\Modules\Newsletter\Observers\MailListObserver;
use Corals\Modules\Newsletter\Observers\EmailObserver;
use Corals\Modules\Newsletter\Observers\SubscriberObserver;
use Illuminate\Support\ServiceProvider;

class NewsletterObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {

        MailList::observe(MailListObserver::class);
        Subscriber::observe(SubscriberObserver::class);
        Email::observe(EmailObserver::class);
    }
}