<?php



// Subscriptions
Breadcrumbs::register('subscriptions', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Subscriptions::module.subscription.title'));
});

Breadcrumbs::register('subscription_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('subscriptions');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('card', function ($breadcrumbs) {
    $breadcrumbs->parent('subscriptions');
    $breadcrumbs->push(trans('Subscriptions::module.card.configuration'));
});

Breadcrumbs::register('pricing', function ($breadcrumbs) {
    $breadcrumbs->parent('subscriptions');
    $breadcrumbs->push(trans('Subscriptions::module.pricing.title'));
});


//Product
Breadcrumbs::register('products', function ($breadcrumbs) {
    $breadcrumbs->parent('subscriptions');
    $breadcrumbs->push(trans('Subscriptions::module.product.title'), url(config('subscriptions.models.product.resource_url')));
});

Breadcrumbs::register('product_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('products');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('product_show', function ($breadcrumbs) {
    $breadcrumbs->parent('products');
    $breadcrumbs->push(view()->shared('title_singular'));
});
//Plans
Breadcrumbs::register('plans', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('products');
    $breadcrumbs->push(trans('Subscriptions::module.plan.name',['name' => $product->name]), route(config('subscriptions.models.plan.resource_route'), ['product' => $product->hashed_id]));
});

Breadcrumbs::register('plan_create_edit', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('plans', $product);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('plan_show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('plans', $product);
    $breadcrumbs->push(view()->shared('title_singular'));
});
//Features
Breadcrumbs::register('features', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('products');
    $breadcrumbs->push(trans('Subscriptions::module.feature.name',['name' => $product->name]), route(config('subscriptions.models.feature.resource_route'), ['product' => $product->hashed_id]));
});

Breadcrumbs::register('feature_create_edit', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('features', $product);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('feature_show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('features', $product);
    $breadcrumbs->push(view()->shared('title_singular'));
});