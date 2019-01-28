<?php

//Directory
Breadcrumbs::register('directory', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
});


//Listings
Breadcrumbs::register('directory_listings', function ($breadcrumbs) {
    $breadcrumbs->parent('directory');
    $breadcrumbs->push(trans('Directory::module.listing.title'), url(config('directory.models.listing.resource_url')));
});

Breadcrumbs::register('directory_listing_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('directory_listings');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('directory_listing_show', function ($breadcrumbs) {
    $breadcrumbs->parent('directory_listings');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//Claims
Breadcrumbs::register('directory_claims', function ($breadcrumbs) {
    $breadcrumbs->parent('directory');
    $breadcrumbs->push(trans('Directory::module.claim.title'), url(config('directory.models.claim.resource_url')));
});