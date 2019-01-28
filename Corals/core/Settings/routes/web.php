<?php

Route::get('utilities/select2', 'UtilitiesController@select2');

Route::resource('settings', 'SettingsController');

Route::resource('custom-fields', 'CustomFieldSettingsController', [
    'parameters' => ['custom-fields' => 'customFieldSetting'],
    'except' => ['show']
]);

Route::get('settings/download/{setting}', 'SettingsController@fileDownload');

Route::group(['prefix' => 'modules'], function () {
    Route::get('/', 'ModulesController@index');
    Route::get('/rescan', 'ModulesController@index');
    Route::post('{module}/install', 'ModulesController@install');
    Route::post('{module}/uninstall', 'ModulesController@uninstall');
    Route::post('{module}/update', 'ModulesController@update');
    Route::post('{module}/download', 'ModulesController@downloadRemote');
    Route::post('{module}/{status}', 'ModulesController@toggleStatus');

    Route::get('/add', 'ModulesController@add');

    Route::post('/add', 'ModulesController@downloadNew');

    Route::get('{module}/license-key', 'ModulesController@licenseKey');
    Route::put('{module}/license-key', 'ModulesController@saveLicenseKey');
});

Route::get('cache-management', 'SettingsController@cacheIndex');
Route::post('cache-management/{action}', 'SettingsController@cacheAction');