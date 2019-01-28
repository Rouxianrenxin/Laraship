<?php

namespace Corals\Modules\Subscriptions\Providers;

use Corals\Modules\Subscriptions\Models\Feature;
use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Corals\Modules\Subscriptions\Observers\FeatureObserver;
use Corals\Modules\Subscriptions\Observers\PlanObserver;
use Corals\Modules\Subscriptions\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class SubscriptionsObserverServiceProvider extends ServiceProvider
{
    /**
     * Register Observers
     */
    public function boot()
    {
        Plan::observe(PlanObserver::class);
        Product::observe(ProductObserver::class);
        Feature::observe(FeatureObserver::class);
    }
}