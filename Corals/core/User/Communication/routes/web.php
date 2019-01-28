<?php

Route::group(['prefix' => ''], function () {
    Route::resource('notification-templates', 'NotificationTemplateController', ['only' => ['index', 'edit', 'update']]);

    //to show current user notifications
    Route::resource('notifications', 'NotificationController', ['only' => ['index', 'show']]);

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('{notification}/read-at-toggle', 'NotificationController@readAtToggle');
    });
});