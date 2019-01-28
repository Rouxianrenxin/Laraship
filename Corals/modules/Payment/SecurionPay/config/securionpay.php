<?php

return [
    'name' => 'SecurionPay',
    'key' => 'payment_securionpay',
    'support_subscription' => true,
    'support_ecommerce' => false,
    'manage_remote_plan' => true,
    'manage_remote_product' => false,
    'manage_remote_sku' => false,
    'manage_remote_order' => false,
    'support_swap' => true,
    'supports_swap_in_grace_period' => true,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'capture_payment_method' => false,
    'require_default_payment_set' => false,
    'can_update_payment' => true,
    'create_remote_customer' => true,
    'require_payment_token' => false,

    'settings' => [
        'live_public_key' => [
            'label' => 'SecurionPay::labels.settings.live_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_secret_key' => [
            'label' => 'SecurionPay::labels.settings.live_secret',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'SecurionPay::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_public_key' => [
            'label' => 'SecurionPay::labels.settings.sandbox_public',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_secret_key' => [
            'label' => 'SecurionPay::labels.settings.sandbox_secret',
            'type' => 'text',
            'required' => false,
        ]
    ],
    'events' => [
        'CHARGE_SUCCEEDED' => \Corals\Modules\Payment\SecurionPay\Job\HandleInvoiceCreated::class,
        'CHARGE_CAPTURED' => \Corals\Modules\Payment\SecurionPay\Job\HandleInvoicePaymentSucceeded::class,
        'CUSTOMER_SUBSCRIPTION_DELETED' => \Corals\Modules\Payment\SecurionPay\Job\HandleCustomerSubscriptionDeleted::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\SecurionPay\Gateway::class,
];