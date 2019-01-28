<?php

//Advert
Breadcrumbs::register('advert', function ($breadcrumbs) {
    $breadcrumbs->push(trans('Advert::module.advert.title'));
});

Breadcrumbs::register('impressions', function ($breadcrumbs) {
    $breadcrumbs->parent('advert');
    $breadcrumbs->push(trans('Advert::module.impression.title'), url(config('advert.models.impression.resource_url')));
});

Breadcrumbs::register('zones', function ($breadcrumbs, $website) {
    if ($website) {
        $breadcrumbs->parent('websites', null);
        $breadcrumbs->push(trans('Advert::module.website.title_singular_name', ['name' => $website->name]), url(config('advert.models.website.resource_url'), $website->hashed_id));
    } else {
        $breadcrumbs->parent('advert');
        $breadcrumbs->push(trans('Advert::module.zone.title'), url(config('advert.models.zone.resource_url')));
    }
});

Breadcrumbs::register('zone_create_edit', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('zones', $website);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('zone_show', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('zones', $website);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('websites', function ($breadcrumbs) {
    $breadcrumbs->parent('advert');
    $breadcrumbs->push(trans('Advert::module.website.title'), url(config('advert.models.website.resource_url')));
});

Breadcrumbs::register('website_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('websites');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('website_show', function ($breadcrumbs) {
    $breadcrumbs->parent('websites');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('banners', function ($breadcrumbs, $campaign) {
    if ($campaign) {
        $breadcrumbs->parent('campaigns', null);
        $breadcrumbs->push(trans('Advert::module.campaign.title_singular_name', ['name' => $campaign->name]), url(config('advert.models.campaign.resource_url'), $campaign->hashed_id));
    } else {
        $breadcrumbs->parent('advert');
        $breadcrumbs->push(trans('Advert::module.banner.title'), url(config('advert.models.banner.resource_url')));
    }
});

Breadcrumbs::register('banner_create_edit', function ($breadcrumbs, $campaign) {
    $breadcrumbs->parent('banners', $campaign);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('banner_show', function ($breadcrumbs, $campaign) {
    $breadcrumbs->parent('banners', $campaign);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('advertisers', function ($breadcrumbs) {
    $breadcrumbs->parent('advert');
    $breadcrumbs->push(trans('Advert::module.advertiser.title'), url(config('advert.models.advertiser.resource_url')));
});

Breadcrumbs::register('advertiser_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('advertisers');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('advertiser_show', function ($breadcrumbs) {
    $breadcrumbs->parent('advertisers');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//campaigns
Breadcrumbs::register('campaigns', function ($breadcrumbs, $advertiser) {
    if ($advertiser) {
        $breadcrumbs->parent('advertisers');
        $breadcrumbs->push(trans('Advert::module.advertiser.title_singular_name', ['name' => $advertiser->name]), url(config('advert.models.advertiser.resource_url') . '/' . $advertiser->hashed_id));
    } else {
        $breadcrumbs->parent('advert');
        $breadcrumbs->push(trans('Advert::module.campaign.title'), url(config('advert.models.advertiser.resource_url')));
    }
});

Breadcrumbs::register('campaign_create_edit', function ($breadcrumbs, $advertiser) {
    $breadcrumbs->parent('campaigns', $advertiser);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('campaign_show', function ($breadcrumbs, $advertiser) {
    $breadcrumbs->parent('campaigns', $advertiser);
    $breadcrumbs->push(view()->shared('title_singular'));
});