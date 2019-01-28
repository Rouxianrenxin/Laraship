<?php

Route::group(['prefix' => ''], function () {
    Route::resource('bars', 'BarsController');
});