<?php

namespace Corals\Modules\Subscriptions\Providers;

use Corals\Modules\Subscriptions\Models\Feature;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Subscriptions\Policies\FeaturePolicy;
use Corals\Modules\Subscriptions\Policies\PlanPolicy;
use Corals\Modules\Subscriptions\Policies\ProductPolicy;
use Corals\Modules\Subscriptions\Policies\SubscriptionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class SubscriptionsAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Plan::class => PlanPolicy::class,
        Product::class => ProductPolicy::class,
        Feature::class => FeaturePolicy::class,
        Subscription::class => SubscriptionPolicy::class,
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
