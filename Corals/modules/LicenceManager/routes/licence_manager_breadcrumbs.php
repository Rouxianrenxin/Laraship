<?php

//Licence
Breadcrumbs::register('licences', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('LicenceManager::module.licence.title'), url(config('licence_manager.models.licence.resource_url')));
});

Breadcrumbs::register('licence_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('licences');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('licence_show', function ($breadcrumbs) {
    $breadcrumbs->parent('licences');
    $breadcrumbs->push(view()->shared('title_singular'));
});