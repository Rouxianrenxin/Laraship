<?php

Route::group(['prefix' => 'messaging'], function () {

    //Discussions
    Route::resource('discussions', 'DiscussionsController', ['except' => ['markAsRead', 'search', 'status', 'bulkAction']]);
    Route::get('discussions/status/{status}', 'DiscussionsController@index');
    Route::post('discussions/{discussion}/markAsRead', 'DiscussionsController@markAsRead');
    Route::post('discussions/bulk-action/{status}', 'DiscussionsController@bulkAction');
    Route::post('discussions/{discussion}/{status}', 'DiscussionsController@toggleStatus');

    //Messages
    Route::resource('messages', 'MessageController', ['except' => ['get_message_body']]);
    Route::post('messages/{message}/get_message_body', 'MessageController@get_message_body');

});