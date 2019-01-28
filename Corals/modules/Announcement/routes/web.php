<?php

Route::group(['prefix' => ''], function () {
    Route::get('announcements/mark-announcement-as-read/{announcement}', 'AnnouncementsController@markAnnouncementAsRead');
    Route::get('announcements/unread-in-url', 'AnnouncementsController@getUnreadAnnouncements');
    Route::resource('announcements', 'AnnouncementsController');
});