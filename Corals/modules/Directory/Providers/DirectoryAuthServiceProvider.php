<?php

namespace Corals\Modules\Directory\Providers;

use Corals\Modules\Utility\Models\Category\Attribute;
use Corals\Modules\Utility\Models\Category\Category;
use Corals\Modules\Directory\Models\Location;
use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Directory\Models\Claim;
use Corals\Modules\Directory\Models\Tag;
use Corals\Modules\Directory\Policies\AttributePolicy;
use Corals\Modules\Directory\Policies\CategoryPolicy;
use Corals\Modules\Directory\Policies\LocationPolicy;
use Corals\Modules\Directory\Policies\ListingPolicy;
use Corals\Modules\Directory\Policies\ClaimPolicy;
use Corals\Modules\Directory\Policies\TagPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class DirectoryAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Listing::class => ListingPolicy::class,
        Claim::class => ClaimPolicy::class,
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