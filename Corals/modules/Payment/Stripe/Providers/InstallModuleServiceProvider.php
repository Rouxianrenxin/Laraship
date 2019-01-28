<?php

namespace Corals\Modules\Payment\Stripe\Providers;

use Carbon\Carbon;
use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function booted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Stripe'] = 'Stripe';
        \Payments::setAvailableGateways($supported_gateways);
        \DB::table('settings')->insert([
            [
                'code' => 'payment_stripe_live_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_live_public_key',
                'value' => 'live_public_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_stripe_live_secret_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_live_secret_key',
                'value' => 'live_secret_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_stripe_live_webhook_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_live_webhook_key',
                'value' => 'live_webhook_xxxxxxxxxxxxxxxxxxxxxx',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_stripe_sandbox_mode',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_sandbox_mode',
                'value' => 'true',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_stripe_sandbox_public_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_sandbox_public_key',
                'value' => 'pk_test_zwrWUut1CmIPmEG1a3AMfOVO',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_stripe_sandbox_secret_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_sandbox_secret_key',
                'value' => 'sk_test_jJcbMlrT1DvS7DuxTE9Ax0Ig',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'payment_stripe_sandbox_webhook_key',
                'type' => 'TEXT',
                'category' => 'Payment',
                'label' => 'payment_stripe_sandbox_webhook_key',
                'value' => 'whsec_8PVxYbVnESo9WWMn9KUrFTtx4tnQ6fc9',
                'editable' => 1,
                'hidden' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        \DB::table('gateway_status')->insert([
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 5,
                'object_reference' => 'gold',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 4,
                'object_reference' => 'silver',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 3,
                'object_reference' => 'bronze',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 8,
                'object_reference' => 'business',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 7,
                'object_reference' => 'professional',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 6,
                'object_reference' => 'basic',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 12,
                'object_reference' => 'platinuim',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 11,
                'object_reference' => 'bushosting',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 10,
                'object_reference' => 'corporate',
                'status' => 'CREATED',
            ],
            [
                'gateway' => 'Stripe',
                'object_type' => 'Corals\Modules\Subscriptions\Models\Plan',
                'object_id' => 9,
                'object_reference' => 'basichosting',
                'status' => 'CREATED',
            ],
        ]);
    }
}
