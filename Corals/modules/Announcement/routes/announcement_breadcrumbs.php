<?php

//Announcement
Breadcrumbs::register('announcements', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Announcement::module.announcement.title'), url(config('announcement.models.announcement.resource_url')));
});

Breadcrumbs::register('announcement_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('announcements');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('announcement_show', function ($breadcrumbs) {
    $breadcrumbs->parent('announcements');
    $breadcrumbs->push(view()->shared('title_singular'));
});