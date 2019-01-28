<?php

namespace Corals\Modules\Payment;

use Corals\Modules\Payment\Providers\PaymentAuthServiceProvider;
use Corals\Modules\Payment\Providers\PaymentObserverServiceProvider;
use Corals\Modules\Payment\Providers\PaymentRouteServiceProvider;
use Corals\Settings\Models\Module;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Torann\Currency\CurrencyServiceProvider;
use Corals\Modules\Payment\Common\Hooks\Payment as PaymentHooks;

class PaymentServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/Common/resources/views', 'Payment');

        //load translation
        $this->loadTranslationsFrom(__DIR__ . '/Common/resources/lang', 'Payment');

        $this->mergeConfigFrom(__DIR__ . '/Common/config/common.php', 'payment_common');
        try {
            $payment_modules = Module::enabled()->installed()->where('type', 'payment')->orderBy('load_order')->get();

            foreach ($payment_modules as $payment_module) {

                $configFilesPath = __DIR__ . '/' . $payment_module->folder . '/config';

                $configFiles = \Illuminate\Support\Facades\File::allFiles($configFilesPath);

                foreach ($configFiles as $file) {
                    $gateway = $file->getBasename('.php');

                    $configKey = 'payment_' . $gateway;

                    $this->mergeConfigFrom($configFilesPath . '/' . $file->getBasename(), $configKey);

                    $gateway_name = config($configKey . '.name');

                    $this->loadViewsFrom(__DIR__ . "/{$gateway_name}/resources/views", $gateway_name);

                    $this->loadTranslationsFrom(__DIR__ . "/{$gateway_name}/resources/lang", $gateway_name);

                    //register gateways webhooks events
                    if ($events = config($configKey . '.events')) {
                        foreach ($events as $eventName => $jobClass) {
                            \Corals\Modules\Payment\Facades\Webhooks::registerEvent("{$gateway}.{$eventName}", $jobClass);
                        }
                    }
                }
            }

            $this->registerWidgets();
            $this->registerHooks();


        } catch (\Exception $exception) {
            if (isset($payment_module)) {
                $payment_module->enabled = 0;
                $payment_module->notes = $exception->getMessage();
                $payment_module->save();
                flash(trans('Payment::exception.payment_service.error_load_module', ['code' => $payment_module->code]))->warning();

            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Webhooks', function ($app) {
            return new Webhooks();
        });


        $this->app->register(CurrencyServiceProvider::class);
        $this->app->register(PaymentRouteServiceProvider::class);
        $this->app->register(PaymentObserverServiceProvider::class);
        $this->app->register(PaymentAuthServiceProvider::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Payments', \Corals\Modules\Payment\Facades\Payments::class);
            $loader->alias('Currency', \Torann\Currency\Facades\Currency::class);


        });

        $this->app['router']->pushMiddlewareToGroup('web', \Torann\Currency\Middleware\CurrencyMiddleware::class);

    }

    public function registerWidgets()
    {
        \Shortcode::addWidget('revenue', \Corals\Modules\Payment\Widgets\RevenueWidget::class);
        \Shortcode::addWidget('monthly_revenue', \Corals\Modules\Payment\Widgets\MonthlyRevenueWidget::class);
    }

    public function registerHooks()
    {
        \Actions::add_action('show_navbar', [PaymentHooks::class, 'show_nav_currencies_menu'], 9);

        \Actions::add_action('post_display_frontend_menu', [PaymentHooks::class, 'show_available_currencies_menu'], 10);
    }

    public function provides()
    {
        return [
            'Webhooks'
        ];
    }
}
