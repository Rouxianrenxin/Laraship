<?php

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

Route::group(['prefix' => 'profile'], function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::put('/', 'ProfileController@update')->name('profile-update');
});

Route::group(['prefix' => ''], function () {
    Route::post('users/{user}/address', 'UsersController@storeAddress');
    Route::get('users/{user}/address/{type}/edit', 'UsersController@editAddress');
    Route::post('users/bulk-action', 'UsersController@bulkAction');

    Route::delete('users/{user}/address/{type}', 'UsersController@destroyAddress');
    Route::resource('users', 'UsersController');
});

Route::group(['prefix' => ''], function () {
    Route::resource('roles', 'RolesController', ['except' => ['show']]);
});

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', 'Auth\LoginController@login');

Route::group(['prefix' => '{role_name?}'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', 'Auth\LoginController@login');
});

Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
Route::post('register', 'Auth\RegisterController@register');

Route::group(['prefix' => '{role_name?}'], function () {
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', 'Auth\RegisterController@register');
});

Route::get('register/confirm/resend', 'Auth\RegisterController@resendConfirmation')->name('auth.resend_confirmation');
Route::get('register/confirm/{confirmation_code}', 'Auth\RegisterController@confirm')->name('auth.confirm');

Route::get('auth/token', 'Auth\TwoFactorController@showTokenForm');
Route::post('auth/token', 'Auth\TwoFactorController@validateTokenForm');
Route::post('auth/two-factor', 'Auth\TwoFactorController@setupTwoFactorAuth');

Route::get('social-auth/{provider}', 'Auth\SocialController@redirectToProvider')->name('auth.social');
Route::get('social-auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback')->name('auth.social.callback');
