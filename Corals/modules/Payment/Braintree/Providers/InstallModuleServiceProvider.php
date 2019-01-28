<?php

namespace Corals\Modules\Payment\Braintree\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Braintree'] = 'Braintree';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_braintree_live_merchant_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_live_merchant_id',
                'value' => 'live_merchant_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_braintree_live_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_live_public_key',
                'value' => 'live_public_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_braintree_live_private_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_live_private_key',
                'value' => 'live_private_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_braintree_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_braintree_sandbox_merchant_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_sandbox_merchant_id',
                'value' => 'nk98kbywts9rv4bn',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_braintree_sandbox_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_sandbox_public_key',
                'value' => '266qkvdjnwp9zr7q',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_braintree_sandbox_private_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_braintree_sandbox_private_key',
                'value' => 'b47a7b1c929a9b0b56bceb979179b42e',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
