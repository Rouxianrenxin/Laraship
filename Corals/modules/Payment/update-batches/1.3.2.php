<?php

\Corals\Settings\Models\Setting::whereIn('code', [
    'payment_braintree_live_merchant_id',
    'payment_braintree_live_public_key',
    'payment_braintree_live_private_key',
    'payment_braintree_sandbox_mode',
    'payment_braintree_sandbox_merchant_id',
    'payment_braintree_sandbox_public_key',
    'payment_braintree_sandbox_private_key',
    'payment_paypal_rest_live_client_id',
    'payment_paypal_rest_live_client_secret',
    'payment_paypal_rest_live_access_token',
    'payment_paypal_rest_live_access_token_expiry',
    'payment_paypal_rest_sandbox_mode',
    'payment_paypal_rest_sandbox_client_id',
    'payment_paypal_rest_sandbox_client_secret',
    'payment_paypal_rest_sandbox_access_token',
    'payment_paypal_rest_sandbox_access_token_expiry',
    'payment_securionpay_live_public_key',
    'payment_securionpay_live_secret_key',
    'payment_securionpay_sandbox_mode',
    'payment_securionpay_sandbox_public_key',
    'payment_securionpay_sandbox_secret_key',
    'payment_stripe_live_public_key',
    'payment_stripe_live_secret_key',
    'payment_stripe_live_webhook_key',
    'payment_stripe_sandbox_mode',
    'payment_stripe_sandbox_public_key',
    'payment_stripe_sandbox_secret_key',
    'payment_stripe_sandbox_webhook_key',
    'supported_payment_gateway'
])->update(['category' => 'Payment']);

\DB::table('permissions')->updateOrInsert(['name' => 'Payment::invoices.create',], [
    'guard_name' => config('auth.defaults.guard'),
    'created_at' => \Carbon\Carbon::now(),
    'updated_at' => \Carbon\Carbon::now(),
]);

