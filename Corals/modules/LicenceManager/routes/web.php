<?php

Route::group(['prefix' => ''], function () {
    Route::resource('licences', 'LicencesController');
});