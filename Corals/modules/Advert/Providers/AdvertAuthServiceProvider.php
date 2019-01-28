<?php

namespace Corals\Modules\Advert\Providers;

use Corals\Modules\Advert\Models\Advertiser;
use Corals\Modules\Advert\Models\Banner;
use Corals\Modules\Advert\Models\Campaign;
use Corals\Modules\Advert\Models\Impression;
use Corals\Modules\Advert\Models\Website;
use Corals\Modules\Advert\Models\Zone;
use Corals\Modules\Advert\Policies\AdvertiserPolicy;
use Corals\Modules\Advert\Policies\BannerPolicy;
use Corals\Modules\Advert\Policies\CampaignPolicy;
use Corals\Modules\Advert\Policies\ImpressionPolicy;
use Corals\Modules\Advert\Policies\WebsitePolicy;
use Corals\Modules\Advert\Policies\ZonePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AdvertAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Zone::class => ZonePolicy::class,
        Banner::class => BannerPolicy::class,
        Impression::class => ImpressionPolicy::class,
        Advertiser::class => AdvertiserPolicy::class,
        Campaign::class => CampaignPolicy::class,
        Website::class => WebsitePolicy::class,
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