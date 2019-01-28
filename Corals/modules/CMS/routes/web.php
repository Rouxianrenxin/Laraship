<?php

Route::group(['prefix' => 'cms'], function () {
    Route::get('active-users', 'CMSController@realTimeVisitors');
    Route::resource('pages', 'PagesController');
    Route::get('pages/{page}/design', 'PagesController@design');
    Route::put('pages/{page}/save-design', 'PagesController@saveDesign');
    Route::resource('posts', 'PostsController');
    Route::resource('categories', 'CategoriesController', ['except' => ['show']]);
    Route::resource('news', 'NewsController');
    Route::resource('faqs', 'FaqsController');
    Route::resource('blocks', 'BlocksController');
    Route::resource('blocks.widgets', 'WidgetsController');
    Route::post('blocks/{block}/widgets/reorder', 'WidgetsController@reorder');
});

Route::group(['prefix' => ''], function () {
    Route::get('/', 'FrontendController@index')->name('frontend_home');
    Route::get('{slug}', 'FrontendController@show')->name('frontend_single');
    Route::get('category/{slug}', 'FrontendController@category')->name('frontend_category');;
    Route::get('tag/{slug}', 'FrontendController@tag')->name('frontend_tag');
    Route::post('contact/email', 'FrontendController@contactEmail');
    Route::get('admin-preview/{slug}', 'FrontendController@adminShow')->middleware('auth');
});

Route::group(['prefix' => 'cms'], function () {
    Route::get('{slug}', 'CMSInternalController@show');
    Route::get('category/{slug}', 'CMSInternalController@category');
    Route::get('tag/{slug}', 'CMSInternalController@tag');
});
