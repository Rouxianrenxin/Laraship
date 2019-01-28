<?php

Route::group(['prefix' => ''], function () {
    Route::resource('activities', 'ActivitiesController', ['only' => ['index', 'show', 'destroy']]);
});
