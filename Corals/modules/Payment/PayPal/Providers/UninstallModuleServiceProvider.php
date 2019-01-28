<?php

namespace Corals\Modules\Payment\PayPal\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Payment\Models\GatewayStatus;
use Corals\Settings\Models\Setting;
use Corals\User\Models\User;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Settings::get('supported_payment_gateway', []);

        if (is_array($supported_gateways)) {
            unset($supported_gateways['PayPal_Rest']);
        }

        \Settings::set('supported_payment_gateway', json_encode($supported_gateways));


        Setting::where('code', 'like', 'payment_paypal_%')->delete();

        User::where('gateway', 'PayPal_Rest')->update(['gateway' => NULL]);

        GatewayStatus::where('gateway', 'PayPal_Rest')->delete();
    }
}
