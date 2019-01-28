<?php

Route::group(['prefix' => 'newsletter'], function () {
    Route::get('mail-lists/{mailList}/subscribers', 'MailListsController@mailListsSubscribers');
    Route::get('mail-tracker/{api_call_id}', 'EmailLoggersController@mailTracker');
    Route::get('import-subscribers-report/{action}', 'SubscribersController@importSubscribersReport');
    Route::get('import-subscribers', 'SubscribersController@importSubscribersView');
    Route::post('import-subscribers', 'SubscribersController@importSubscribers');
    Route::post('email-loggers/{emailLogger}/send-email', 'EmailLoggersController@sendEmail');

    Route::resource('mail-lists', 'MailListsController');
    Route::resource('subscribers', 'SubscribersController');

    Route::post('emails/{email}/send-email', 'EmailsController@sendEmail');
    Route::resource('emails', 'EmailsController');

    Route::resource('email-loggers', 'EmailLoggersController')->except([
        'update', 'edit', 'create', 'store'
    ]);
});