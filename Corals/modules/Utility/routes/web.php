<?php

Route::group(['prefix' => 'utilities'], function () {
    //gallery
    Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
        Route::get('{hashed_id}', ['as' => 'list', 'uses' => 'Gallery\GalleryController@gallery']);
        Route::post('{hashed_id}/upload', ['as' => 'upload', 'uses' => 'Gallery\GalleryController@galleryUpload']);
        Route::post('{media}/mark-as-featured', ['as' => 'mark-as-featured', 'uses' => 'Gallery\GalleryController@galleryItemFeatured']);
        Route::delete('{media}/delete', ['as' => 'delete', 'uses' => 'Gallery\GalleryController@galleryItemDelete']);
    });


    Route::delete('wishlist/{wishlist}', 'Wishlist\WishlistBaseController@destroy');

    Route::group(['prefix' => 'address'], function () {
        Route::resource('locations', 'Address\LocationsController');
    });

    Route::resource('tags', 'Tag\TagsController', ['except' => ['show']]);

    Route::resource('categories', 'Category\CategoriesController', ['except' => ['show']]);
    Route::resource('attributes', 'Category\AttributesController', ['except' => ['show']]);

    Route::resource('ratings', 'Rating\RatingBaseController', ['except' => ['toggleStatus']]);
    Route::post('ratings/{rating}/{status}', 'Rating\RatingBaseController@toggleStatus');
    Route::resource('comments', 'Comment\CommentBaseController');

    //Common routes
    Route::get('categories/attributes/{product_id?}', 'Category\AttributesController@getCategoryAttributes');
    Route::post('newsletter/subscribe/', 'Common\PublicCommonController@subscribeNewsLetter');

    //Invite Friends
    Route::get('invite-friends', 'InviteFriends\InviteFriendsBaseController@getInviteFriendsForm');
    Route::post('invite-friends', 'InviteFriends\InviteFriendsBaseController@sendInvitation');
});
