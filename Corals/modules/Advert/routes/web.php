<?php

Route::group(['prefix' => 'adverts'], function () {
    Route::get('{zone}/embed', 'EmbedController@embed');
    Route::get('ads/{slug}', 'ImpressionsController@click');
    Route::resource('impressions', 'ImpressionsController', ['only' => ['index']]);
    Route::resource('websites', 'WebsitesController');
    Route::resource('zones', 'ZonesController');
    Route::resource('banners', 'BannersController');
    Route::resource('advertisers', 'AdvertisersController');
    Route::resource('campaigns', 'CampaignsController');
});