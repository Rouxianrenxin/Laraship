<?php

namespace Corals\Modules\Payment\Cash\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Cash'] = 'Cash on delivery (COD)';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_cash_cash_notes',
                'type' => 'TEXTAREA',
                'category' => 'Payment',
                'label' => 'payment_cash_cash_notes',
                'value' => 'Payment should be made upon delivery, make sure you check and confirm your shipment',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
