<?php

Route::group(['prefix' => 'e-commerce', 'as' => 'e-commerce.'], function () {
    Route::get('shop', ['as' => 'index', 'uses' => 'ShopController@index']);
    Route::get('shop/{slug}', ['as' => 'show', 'uses' => 'ShopController@show']);
    Route::get('cart', 'CartController@index');

    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CheckoutController@index');
        Route::post('/', 'CheckoutController@doCheckout');
        Route::get('step/{step}', 'CheckoutController@checkoutStep');
        Route::post('step/{step}', 'CheckoutController@saveCheckoutStep');
        Route::get('shipping-address', 'CheckoutController@checkoutShippingAddress');
        Route::get('order-success', 'CheckoutController@showOrderSuccessPage');
    });

    Route::get('products/download/{id}', 'ProductsController@downloadFile');
    Route::resource('products', 'ProductsController');
    Route::resource('categories', 'CategoriesController', ['except' => ['show']]);
    Route::resource('attributes', 'AttributesController', ['except' => ['show']]);
    Route::resource('tags', 'TagsController', ['except' => ['show']]);
    Route::resource('brands', 'BrandsController', ['except' => ['show']]);
    Route::post('products/{product}/create-gateway-product', ['as' => 'create-gateway-product', 'uses' => 'ProductsController@createGatewayProduct']);
    Route::get('gateway-payment/{gateway}', 'CartController@gatewayPayment');


    Route::group(['prefix' => 'products', 'as' => 'product-gallery.'], function () {
        Route::get('{product}/gallery', ['as' => 'list', 'uses' => 'ProductsController@gallery']);
        Route::post('{product}/gallery/upload', ['as' => 'upload', 'uses' => 'ProductsController@galleryUpload']);
        Route::post('{media}/gallery/mark-as-featured', ['as' => 'mark-as-featured', 'uses' => 'ProductsController@galleryItemFeatured']);
        Route::delete('{media}/gallery/delete', ['as' => 'delete', 'uses' => 'ProductsController@galleryItemDelete']);
    });

    Route::group(['prefix' => 'wishlist'], function () {
        Route::post('{product}', 'WishlistController@setWishlist');
        Route::delete('{wishlist}', 'WishlistController@destroy');
        Route::get('my', ['as' => 'my-wishlist', 'uses' => 'WishlistController@myWishlist']);

    });

    Route::resource('products.sku', 'SKUController');
    Route::post('products/{product}/sku/{sku}/create-gateway-sku', ['as' => 'create-gateway-sku', 'uses' => 'SKUController@createGatewaySKU']);

    Route::get('orders/my', ['as' => 'my-orders', 'uses' => 'OrdersController@myOrders']);
    Route::get('downloads/my', ['as' => 'my-downloads', 'uses' => 'OrdersController@myDownloads']);
    Route::get('private-pages/my', ['as' => 'my-private-pages', 'uses' => 'OrdersController@myPrivatePages']);
    Route::resource('orders', 'OrdersController', ['only' => ['index', 'show', 'edit', 'update']]);
    Route::get('orders/{order}/track', 'OrdersController@track');
    Route::get('orders/{order}/download/{id}', 'OrdersController@downloadFile');

    Route::get('settings', 'ShopController@settings');
    Route::post('settings', 'ShopController@saveSettings');

    Route::get('gateway-payment/{gateway}/{order?}', 'CheckoutController@gatewayPayment');
    Route::get('gateway-payment-token/{gateway}/{order?}', 'CheckoutController@gatewayPaymentToken');

    Route::resource('coupons', 'CouponsController');
    Route::resource('shippings', 'ShippingsController');
});


Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'ShopPublicController@index']);
    Route::post('{product}/rate', ['as' => 'show', 'uses' => 'RatingController@createRating']);
    Route::get('{slug}', ['as' => 'show', 'uses' => 'ShopPublicController@show']);
});


Route::group(['prefix' => 'cart'], function () {
    Route::get('/', 'CartPublicController@index');
    Route::post('empty', 'CartPublicController@emptyCart');
    Route::post('quantity/{itemhash}', 'CartPublicController@setQuantity');
    Route::post('{product}/add-to-cart/{sku?}', 'CartPublicController@addToCart');
});

Route::group(['prefix' => 'checkout'], function () {
    Route::get('/', 'CheckoutPublicController@index');
    Route::post('/', 'CheckoutPublicController@doCheckout');
    Route::get('step/{step}', 'CheckoutPublicController@checkoutStep');
    Route::post('step/{step}', 'CheckoutPublicController@saveCheckoutStep');
    Route::get('shipping-address', 'CheckoutPublicController@checkoutShippingAddress');
    Route::get('order-success', 'CheckoutPublicController@showOrderSuccessPage');
});

