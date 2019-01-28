<?php

Route::group(['prefix' => 'directory'], function () {
    // admin routes
    Route::resource('listings', 'ListingsController', ['except' => ['show']]);
    Route::resource('claims', 'ClaimController', ['except' => ['toggleStatus', 'declineResons']]);
    Route::post('claims/{claim}/{status}', 'ClaimController@toggleStatus');
    Route::get('claims/{claim}/reasons', 'ClaimController@declineReasons');

    Route::group(['prefix' => 'wishlist'], function () {
        Route::post('{listing}', 'WishlistController@setWishlist');
        Route::get('my', ['as' => 'my-wishlist', 'uses' => 'WishlistController@myWishlist']);
    });

    //User routes
    Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
        Route::get('dashboard', 'DashboardController@index');
        Route::resource('listings', 'UserListingController');
        Route::post('{listing}/rate', ['as' => 'show', 'uses' => 'RatingController@createRating']);
        Route::get('reviews', 'UserListingController@getListingReviews');
        Route::post('{rate}/create-comment', 'CommentController@createComment');
        Route::post('{listing}/claim', 'ClaimController@store');
        Route::get('invite-friends', 'InviteFriendsController@getInviteFriendsForm');
        Route::post('invite-friends', 'InviteFriendsController@sendInvitation');
    });
    Route::post('listings/contact', 'ListingPublicController@contact');
});


Route::get('listings/', 'ListingPublicController@index');
Route::get('listings/{slug}', 'ListingPublicController@show');
