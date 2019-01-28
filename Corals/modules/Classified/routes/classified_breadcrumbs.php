<?php

//Classified
Breadcrumbs::register('classified', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
});

//Products
Breadcrumbs::register('classified_products', function ($breadcrumbs) {
    $breadcrumbs->parent('classified');
    $breadcrumbs->push(trans('Classified::module.product.title'), url(config('classified.models.product.resource_url')));
});

Breadcrumbs::register('classified_product_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('classified_products');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('classified_product_show', function ($breadcrumbs) {
    $breadcrumbs->parent('classified_products');
    $breadcrumbs->push(view()->shared('title_singular'));
});
