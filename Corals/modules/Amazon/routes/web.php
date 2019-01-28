<?php

Route::group(['prefix' => 'amazon'], function () {
    Route::resource('imports', 'ImportsController');
    Route::get('process-imports', 'ImportsController@processImports');

    Route::get('settings', 'AmazonController@settings');
    Route::post('settings', 'AmazonController@saveSettings');

});

