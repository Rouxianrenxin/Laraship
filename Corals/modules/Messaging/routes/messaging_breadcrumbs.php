<?php

//Discussion
Breadcrumbs::register('discussions', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Messaging::module.discussion.title'), url(config('messaging.models.discussion.resource_url')));
});

Breadcrumbs::register('discussion_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('discussions');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('discussion_show', function ($breadcrumbs) {
    $breadcrumbs->parent('discussions');
    $breadcrumbs->push(view()->shared('title_singular'));
});