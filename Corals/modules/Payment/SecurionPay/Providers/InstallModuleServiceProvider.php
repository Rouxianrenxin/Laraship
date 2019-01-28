<?php

namespace Corals\Modules\Payment\SecurionPay\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['SecurionPay'] = 'SecurionPay';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_securionpay_live_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_securionpay_live_public_key',
                'value' => 'live_public_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_securionpay_live_secret_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_securionpay_live_secret_key',
                'value' => 'live_secret_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_securionpay_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_securionpay_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_securionpay_sandbox_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_securionpay_sandbox_public_key',
                'value' => 'pk_test_QlitsJUyyaI0sJ2OlQGVFjfo',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_securionpay_sandbox_secret_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_securionpay_sandbox_secret_key',
                'value' => 'sk_test_6xdW9EQIKtPcNjm0ZxP9O3nG',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
