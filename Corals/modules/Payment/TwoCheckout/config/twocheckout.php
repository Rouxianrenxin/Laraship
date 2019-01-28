<?php

return [
    'name' => 'TwoCheckout',
    'key' => 'payment_twocheckout',
    'support_subscription' => true,
    'support_ecommerce' => false,
    'manage_remote_plan' => false,
    'create_remote_customer' => false,
    'capture_payment_method' => true,
    'require_default_payment_set' => true,
    'support_swap' => false,
    'can_update_payment' => true,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'require_payment_token' => false,

    'settings' => [
        'live_merchant_id' => [
            'label' => 'TwoCheckout::labels.settings.live_merchant',
            'type' => 'text',
            'required' => false,
        ],
        'live_public_key' => [
            'label' => 'TwoCheckout::labels.settings.live_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_private_key' => [
            'label' => 'TwoCheckout::labels.settings.live_private_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_admin_username' => [
            'label' => 'TwoCheckout::labels.settings.live_admin_name',
            'type' => 'text',
            'required' => false,
        ],
        'live_admin_password' => [
            'label' => 'TwoCheckout::labels.settings.live_password',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'TwoCheckout::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_merchant_id' => [
            'label' => 'TwoCheckout::labels.settings.sandbox_merchant',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_public_key' => [
            'label' => 'TwoCheckout::labels.settings.sandbox_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_private_key' => [
            'label' => 'TwoCheckout::labels.settings.sandbox_private_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_admin_username' => [
            'label' => 'TwoCheckout::labels.settings.sandbox_admin_name',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_admin_password' => [
            'label' => 'TwoCheckout::labels.settings.sandbox_admin_password',
            'type' => 'text',
            'required' => false,
        ],
    ],
    'events' => [

        'RECURRING_STOPPED' => \Corals\Modules\Payment\TwoCheckout\Job\HandleSubscriptionDeleted::class,
        'RECURRING_INSTALLMENT_SUCCESS' => \Corals\Modules\Payment\TwoCheckout\Job\HandleRecurringSuccess::class,
        'RECURRING_INSTALLMENT_FAILED' => \Corals\Modules\Payment\TwoCheckout\Job\HandleRecurringFailed::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\TwoCheckout\Gateway::class,
];