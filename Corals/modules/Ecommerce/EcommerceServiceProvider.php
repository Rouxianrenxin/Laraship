<?php

namespace Corals\Modules\Ecommerce;

use Corals\Modules\Ecommerce\Facades\OrderManager;
use Corals\Modules\Ecommerce\Facades\Shipping;
use Corals\Modules\Ecommerce\Facades\Shop;
use Corals\Modules\Ecommerce\Facades\ShoppingCart;
use Corals\Modules\Ecommerce\Facades\Ecommerce as EcommerceFacade;
use Corals\Modules\Ecommerce\Classes\ShoppingCart as ShoppingCartClass;
use Corals\Modules\Ecommerce\Hooks\Ecommerce;

use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Modules\Ecommerce\Notifications\OrderReceivedNotification;
use Corals\Modules\Ecommerce\Notifications\OrderUpdatedNotification;
use Corals\Modules\Ecommerce\Providers\EcommerceAuthServiceProvider;
use Corals\Modules\Ecommerce\Providers\EcommerceObserverServiceProvider;
use Corals\Modules\Ecommerce\Providers\EcommerceRouteServiceProvider;
use Corals\User\Communication\Facades\CoralsNotification;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class EcommerceServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Ecommerce');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Ecommerce');

        // Load migrations
        //$this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->registerHooks();
        $this->registerWidgets();
        $this->addEvents();
        $this->registerCustomFieldsModels();

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/ecommerce.php', 'ecommerce');

        $this->app->register(EcommerceRouteServiceProvider::class);
        $this->app->register(EcommerceAuthServiceProvider::class);
        $this->app->register(EcommerceObserverServiceProvider::class);


        $this->app->singleton(ShoppingCartClass::SERVICE, function ($app) {
            return new ShoppingCartClass($app['session'], $app['events'], $app['auth']);
        });

        //register alias instead of adding it to config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('ShoppingCart', ShoppingCart::class);
            $loader->alias('Ecommerce', EcommerceFacade::class);
            $loader->alias('OrderManager', OrderManager::class);
            $loader->alias('Shop', Shop::class);
            $loader->alias('Shipping', Shipping::class);

        });


    }

    public function registerHooks()
    {
        \Actions::add_action('show_navbar', [Ecommerce::class, 'show_cart_icon'], 11);
        \Actions::add_action('user_profile_tabs', [Ecommerce::class, 'show_profile_tabs_items'], 11);
        \Actions::add_action('user_profile_tabs_content', [Ecommerce::class, 'show_profile_tabs_content'], 11);
        \Filters::add_filter('dashboard_content', [Ecommerce::class, 'dashboard_content'], 8);

    }

    public function registerWidgets()
    {
        \Shortcode::addWidget('orders', \Corals\Modules\Ecommerce\Widgets\OrdersWidget::class);
        \Shortcode::addWidget('products', \Corals\Modules\Ecommerce\Widgets\ProductsWidget::class);
        \Shortcode::addWidget('coupons', \Corals\Modules\Ecommerce\Widgets\CouponsWidget::class);
        \Shortcode::addWidget('product_categories', \Corals\Modules\Ecommerce\Widgets\ProductCategoriesWidget::class);
        \Shortcode::addWidget('brand_ratio', \Corals\Modules\Ecommerce\Widgets\BrandRatioWidget::class);

        \Shortcode::addWidget('my_orders', \Corals\Modules\Ecommerce\Widgets\MyOrdersWidget::class);
        \Shortcode::addWidget('my_wishlist', \Corals\Modules\Ecommerce\Widgets\MyWishlistWidget::class);
        \Shortcode::addWidget('my_downloads', \Corals\Modules\Ecommerce\Widgets\MyDownloadsWidget::class);
        \Shortcode::addWidget('my_private_pages', \Corals\Modules\Ecommerce\Widgets\MyPrivatePagesWidget::class);



    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Product::class, 'Product (Ecommerce)');
        Settings::addCustomFieldModel(SKU::class);
    }

    protected function addEvents()
    {
        CoralsNotification::addEvent(
            'notifications.e_commerce.order.received',
            'Ecommerce Order Received',
            OrderReceivedNotification::class);

        CoralsNotification::addEvent(
            'notifications.e_commerce.order.updated',
            'Order Updated',
            OrderUpdatedNotification::class);
    }
}
