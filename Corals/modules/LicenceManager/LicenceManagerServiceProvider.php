<?php

namespace Corals\Modules\LicenceManager;

use Corals\Modules\Ecommerce\Models\Order;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\LicenceManager\Facades\LicenceManager;
use Corals\Modules\LicenceManager\Classes\LicenceManager as LicenceManagerClass;
use Corals\Modules\LicenceManager\Models\Licence;
use Corals\Modules\LicenceManager\Providers\LicenceManagerAuthServiceProvider;
use Corals\Modules\LicenceManager\Providers\LicenceManagerObserverServiceProvider;
use Corals\Modules\LicenceManager\Providers\LicenceManagerRouteServiceProvider;

use Corals\Modules\LicenceManager\Hooks\Licenceable;
use Corals\Modules\LicenceManager\Hooks\LicenceParent;
use Corals\Settings\Facades\Settings;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LicenceManagerServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application events.
     * @throws \ReflectionException
     */

    public function boot()
    {
        // Load view
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'LicenceManager');

        // Load translation
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'LicenceManager');

        $this->registerCustomFieldsModels();

        // add mixin
        $licenceParent = new LicenceParent();
        Order::mixin($licenceParent);


        $licenceable = new Licenceable();
        Product::mixin($licenceable);

        \Actions::add_action('post_ecommerce_pay_order', [LicenceManagerClass::class, 'post_ecommerce_pay_order'], 710);
        \Actions::add_action('ecommerce_order_post_details', [LicenceManagerClass::class, 'ecommerce_order_post_details'], 710);
        \Actions::add_action('ecommerce_product_form_post_fields', [LicenceManagerClass::class, 'ecommerce_product_form_post_fields'], 710);
        \Filters::add_filter('sku_pre_stock_status', [LicenceManagerClass::class, 'sku_pre_stock_status'], 710);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/licence_manager.php', 'licence_manager');

        $this->app->register(LicenceManagerRouteServiceProvider::class);
        $this->app->register(LicenceManagerAuthServiceProvider::class);
        $this->app->register(LicenceManagerObserverServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('LicenceManager', LicenceManager::class);
        });
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Licence::class);
    }
}
