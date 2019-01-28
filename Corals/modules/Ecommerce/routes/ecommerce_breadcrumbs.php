<?php

// Ecommerce
Breadcrumbs::register('ecommerce', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Ecommerce::module.ecommerce.title'));
});

Breadcrumbs::register('ecommerce_cart', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.cart.title'), url('e-commerce/cart'));
});

Breadcrumbs::register('ecommerce_orders', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.order.title'));
});

Breadcrumbs::register('ecommerce_wishlist', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.wishlist.title_singular'));
});


Breadcrumbs::register('ecommerce_shop', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.shop.title'), url('e-commerce/shop'));
});

Breadcrumbs::register('ecommerce_settings', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.shop.title'), url('e-commerce/settings'));
});

Breadcrumbs::register('ecommerce_products', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.product.title'), url(config('ecommerce.models.product.resource_url')));
});

Breadcrumbs::register('ecommerce_product_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_products');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('ecommerce_product_show', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_products');
    $breadcrumbs->push(view()->shared('title_singular'));
});


//SKU
Breadcrumbs::register('sku', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('ecommerce_products');
    $breadcrumbs->push(trans('Ecommerce::module.sku.product_title', ['product' => $product->name]), route(config('ecommerce.models.sku.resource_route'), ['product' => $product->hashed_id]));
});

Breadcrumbs::register('sku_create_edit', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('sku', $product);
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('sku_show', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('sku', $product);
    $breadcrumbs->push(view()->shared('title_singular'));
});


//Category
Breadcrumbs::register('ecommerce_categories', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.category.title'), url(config('ecommerce.models.category.resource_url')));
});


//Coupon
Breadcrumbs::register('ecommerce_coupon_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_coupons');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('ecommerce_coupons', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.coupon.title'), url(config('ecommerce.models.coupon.resource_url')));
});

//Shippings
Breadcrumbs::register('ecommerce_shipping_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_shippings');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('ecommerce_shippings', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.shipping.title'), url(config('ecommerce.models.shipping.resource_url')));
});

Breadcrumbs::register('ecommerce_category_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_categories');
    $breadcrumbs->push(view()->shared('title_singular'));
});


//Tag
Breadcrumbs::register('ecommerce_tags', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.tag.title'), url(config('ecommerce.models.tag.resource_url')));
});

Breadcrumbs::register('ecommerce_tag_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_tags');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//attribute
Breadcrumbs::register('ecommerce_attributes', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.attribute.title_singular'), url(config('ecommerce.models.attribute.resource_url')));
});

Breadcrumbs::register('ecommerce_attribute_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_attributes');
    $breadcrumbs->push(view()->shared('title_singular'));
});


//Brand
Breadcrumbs::register('ecommerce_brands', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce');
    $breadcrumbs->push(trans('Ecommerce::module.brand.title'), url(config('ecommerce.models.brand.resource_url')));
});

Breadcrumbs::register('ecommerce_brand_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('ecommerce_brands');
    $breadcrumbs->push(view()->shared('title_singular'));
});