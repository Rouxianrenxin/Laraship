<?php

//Import
Breadcrumbs::register('imports', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Amazon::module.import.title'), url(config('amazon.models.import.resource_url')));
});

Breadcrumbs::register('import_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('imports');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('import_show', function ($breadcrumbs) {
    $breadcrumbs->parent('imports');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//Settings
Breadcrumbs::register('amazon_settings', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Amazon::setting.title'), 'amazon/settings');
});