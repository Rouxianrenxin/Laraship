<?php

namespace Corals\Modules\Payment\TwoCheckout\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['TwoCheckout'] = 'TwoCheckout';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_twocheckout_live_merchant_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_live_merchant_id',
                'value' => 'live_merchant_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_live_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_live_public_key',
                'value' => 'live_public_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_live_private_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_live_private_key',
                'value' => 'live_private_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_live_admin_username',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_live_admin_username',
                'value' => 'corals_sandabox',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_live_admin_password',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_live_admin_password',
                'value' => 'Corals123!',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_sandbox_merchant_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_sandbox_merchant_id',
                'value' => '901378332',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_sandbox_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_sandbox_public_key',
                'value' => 'EB0EF924-C0FB-45E1-A442-EDAA2B51C9FF',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_sandbox_private_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_sandbox_private_key',
                'value' => '3B1F8BE0-6746-400B-8457-0D99B7967B34',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_sandbox_admin_username',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_sandbox_admin_username',
                'value' => 'corals_sandabox',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_twocheckout_sandbox_admin_password',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_twocheckout_sandbox_admin_password',
                'value' => 'Corals123!',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
