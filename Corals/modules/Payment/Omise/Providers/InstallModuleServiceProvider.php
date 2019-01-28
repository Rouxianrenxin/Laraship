<?php

namespace Corals\Modules\Payment\Omise\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Omise'] = 'Omise';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_omise_live_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_omise_live_public_key',
                'value' => 'live_public_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_omise_live_private_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_omise_live_private_key',
                'value' => 'live_private_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_omise_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_omise_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_omise_sandbox_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_omise_sandbox_public_key',
                'value' => 'pkey_test_5c92hzebwwpfrd4cj8z',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_omise_sandbox_private_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_omise_sandbox_private_key',
                'value' => 'skey_test_5c92hzec6g9mmh5dx67',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
