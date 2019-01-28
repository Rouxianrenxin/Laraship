<?php

Route::group(['prefix' => 'slider'], function () {
    Route::resource('sliders', 'SlidersController');
    Route::resource('sliders.slides', 'SlidesController');

});