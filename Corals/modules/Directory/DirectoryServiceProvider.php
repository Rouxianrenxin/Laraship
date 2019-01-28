<?php

namespace Corals\Modules\Directory;

use Corals\Modules\Directory\Hooks\HasListing;
use Corals\Modules\Directory\Notifications\ListingApproved;
use Corals\Modules\Directory\Notifications\ListingRejected;
use Corals\User\Communication\Facades\CoralsNotification;
use Corals\Modules\Directory\Facades\Directory;
use Corals\Modules\Utility\Classes\Wishlist\WishlistManager as Wishlist;
use Corals\Modules\Utility\Facades\Utility;
use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Directory\Notifications\ListingCreated;
use Corals\Modules\Directory\Notifications\ListingClaim;
use Corals\Modules\Directory\Notifications\ClaimApprovedStatus;
use Corals\Modules\Directory\Notifications\ClaimDeclineStatus;
use Corals\Modules\Directory\Providers\DirectoryAuthServiceProvider;
use Corals\Modules\Directory\Providers\DirectoryObserverServiceProvider;
use Corals\Modules\Directory\Providers\DirectoryRouteServiceProvider;
use Corals\Modules\Directory\Hooks\Directory as DirectoryHook;

use Corals\Settings\Facades\Settings;
use Corals\User\Models\User;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class DirectoryServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */

    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Directory');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Directory');

        $this->registerCustomFieldsModels();

        \Filters::add_filter('auth_theme', [DirectoryHook::class, 'auth_theme'], 110);
        \Filters::add_filter('auth_redirect_to', [DirectoryHook::class, 'auth_redirect_to'], 110);
        \Filters::add_filter('dashboard_url', [DirectoryHook::class, 'directory_dashboard_url'], 110);

        \JavaScript::put([
            'twitter_id' => Settings::get('twitter_id'),
        ]);

        $this->addEvents();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/directory.php', 'directory');

        $this->app->register(DirectoryRouteServiceProvider::class);
        $this->app->register(DirectoryAuthServiceProvider::class);
        $this->app->register(DirectoryObserverServiceProvider::class);
        //register Settings alias instead of adding it to config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Directory', Directory::class);
            $loader->alias('Wishlist', Wishlist::class);

        });

        Utility::addToUtilityModules('Directory');

        $has_listing = new HasListing();
        User::mixin($has_listing);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Listing::class, 'Listing (Directory)');
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.directory.listing_created',
            'Listing Created',
            ListingCreated::class);

        CoralsNotification::addEvent(
            'notifications.directory.listing_claim',
            'Listing Claim',
            ListingClaim::class);

        CoralsNotification::addEvent(
            'notifications.directory.claim_approved_status',
            'Listing has Approved',
            ClaimApprovedStatus::class);

        CoralsNotification::addEvent(
            'notifications.directory.claim_decline_status',
            'Claim Decline Status',
            ClaimDeclineStatus::class);

        CoralsNotification::addEvent(
            'notifications.directory.listing_approved',
            'Listing Approved',
            ListingApproved::class);

        CoralsNotification::addEvent(
            'notifications.directory.listing_rejected',
            'Listing Rejected',
            ListingRejected::class);

    }
}
