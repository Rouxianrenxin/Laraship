<?php

//Bar
Breadcrumbs::register('bars', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Foo::module.bar.title'), url(config('foo.models.bar.resource_url')));
});

Breadcrumbs::register('bar_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('bars');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('bar_show', function ($breadcrumbs) {
    $breadcrumbs->parent('bars');
    $breadcrumbs->push(view()->shared('title_singular'));
});