<?php

namespace Corals\Modules\Payment\PayPal\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['PayPal_Rest'] = 'PayPal';

        \Payments::setAvailableGateways($supported_gateways);

        \DB::table('settings')->insert([
            [
                'code' => 'payment_paypal_rest_live_client_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_live_client_id',
                'value' => 'live_client_id_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_live_client_secret',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_live_client_secret',
                'value' => 'live_client_secret_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_live_access_token',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_live_access_token',
                'value' => 'live_access_token_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_live_access_token_expiry',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_live_access_token_expiry',
                'value' => 'live_access_token_expiry_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_sandbox_client_id',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_sandbox_client_id',
                'value' => 'AZUgKksKCFROYGrnArvGgD8gQfNDyn31IqXTI1-EOOXNG41VX_PDT09Jv-bGoEnDx26WVOem01qrM-yb',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_sandbox_client_secret',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_sandbox_client_secret',
                'value' => 'EK-mfBgXmaT3C-AjGNygNUd6_7tKNGexJbmJAeN4-TCyshheRu1P2RkYyCz1Fs8gPMX7Te33Zt_nKrDX',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_sandbox_access_token',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_sandbox_access_token',
                'value' => null,
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_paypal_rest_sandbox_access_token_expiry',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_paypal_rest_sandbox_access_token_expiry',
                'value' => null,
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        \DB::table('gateway_status')->insert([
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 5,
                'object_reference' => 'P-35A45995E790655492KEKY2A',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 4,
                'object_reference' => 'P-1C8559013J153541E2KEOLQQ',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 3,
                'object_reference' => 'P-9SN748465A473292R2KET6PI',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 8,
                'object_reference' => 'P-3HF888155494320232KE2KFA',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 7,
                'object_reference' => 'P-1VH360051Y78696492KE5NUY',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 6,
                'object_reference' => null,
                'status' => 'CREATE_FAILED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 12,
                'object_reference' => 'P-07Y10119GX380004X2KF45CQ',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 11,
                'object_reference' => 'P-6AG81380WF340342W2KGA2OY',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 10,
                'object_reference' => 'P-9S718541AD773481G2KGGNWY',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'PayPal_Rest',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 9,
                'object_reference' => 'P-3LK056448F49229252KGKMEA',
                'status' => 'CREATED',
            ],
        ]);
    }
}
