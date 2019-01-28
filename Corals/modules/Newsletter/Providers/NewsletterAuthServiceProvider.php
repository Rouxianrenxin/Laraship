<?php

namespace Corals\Modules\Newsletter\Providers;

use Corals\Modules\Newsletter\Models\MailList;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\Modules\Newsletter\Policies\MailListPolicy;
use Corals\Modules\Newsletter\Policies\EmailPolicy;
use Corals\Modules\Newsletter\Policies\SubscriberPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class NewsletterAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        MailList::class => MailListPolicy::class,
        Subscriber::class => SubscriberPolicy::class,
        Email::class => EmailPolicy::class,
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