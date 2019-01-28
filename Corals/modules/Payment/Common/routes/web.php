<?php

Route::group(['prefix' => 'payments'], function () {
    Route::get('settings', 'PaymentsController@settings');
    Route::post('settings', 'PaymentsController@saveSettings');
});

Route::get('my-invoices', 'InvoicesController@myInvoices');
Route::resource('invoices', 'InvoicesController');
Route::get('invoices/{invoice}/download', 'InvoicesController@download');
Route::post('webhooks/{gateway?}', 'WebhooksController');
Route::resource('currencies' ,'CurrenciesController');

Route::group(['prefix' => 'tax'], function () {
    Route::resource('tax-classes', 'TaxClassesController');
    Route::resource('tax-classes.taxes', 'TaxesController');

});

Route::resource('transactions', 'TransactionsController');


Route::group(['prefix' => 'webhook-calls'], function () {
    Route::get('/', 'WebhooksController@webhookCalls');
    Route::post('{webhookCall}/process', 'WebhooksController@Process');
    Route::post('bulk-action', 'WebhooksController@bulkAction');


});



