<?php

namespace Corals\Modules\Payment\AuthorizeNet\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['AuthorizeNet'] = 'AuthorizeNet';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_authorizenet_live_login_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_live_login_id',
                'value' => 'live_merchant_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_live_transaction_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_live_transaction_key',
                'value' => 'live_merchant_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_live_client_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_live_client_key',
                'value' => 'live_merchant_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_live_signature',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_sandbox_signature',
                'value' => 'live_merchant_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_sandbox_login_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_sandbox_login_id',
                'value' => '27mZJa2fD',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_sandbox_transaction_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_sandbox_transaction_key',
                'value' => '8h22ytQZ62P5hgQF',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_sandbox_client_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_sandbox_client_key',
                'value' => '2JS8SRU6Qxf4EDcy2JZKc472SvndA947UaW4HA8Q4yP4Kc26M2P7qjxz4cXy6JJZ',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_authorizenet_sandbox_signature',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_authorizenet_sandbox_signature',
                'value' => '03459D49F71CF523697B9A77F5D36A9F766E77BD3527374C0A0E2771EA63C04D4C0ED1DF7FCF1855A4B4E063DFFFF213924A55D90CAECFA7C9715A7D115E4E5C',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
