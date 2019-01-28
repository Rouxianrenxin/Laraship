<?php

namespace Corals\Modules\Messaging\Providers;

use Corals\Modules\Messaging\Models\Discussion;
use Corals\Modules\Messaging\Models\Message;
use Corals\Modules\Messaging\Models\Participation;
use Corals\Modules\Messaging\Policies\DiscussionPolicy;
use Corals\Modules\Messaging\Policies\MessagePolicy;
use Corals\Modules\Messaging\Policies\ParticipationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class MessagingAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Discussion::class => DiscussionPolicy::class,
        Message::class => MessagePolicy::class,
        Participation::class => ParticipationPolicy::class,
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