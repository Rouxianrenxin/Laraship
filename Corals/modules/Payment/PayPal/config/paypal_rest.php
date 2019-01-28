<?php

return [
    'name' => 'PayPal',
    'key' => 'payment_paypal_rest',
    'supports_swap' => false,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => true,
    'capture_payment_method' => false,
    'require_default_payment_set' => false,
    'can_update_payment' => false,
    'create_remote_customer' => false,
    'require_payment_token' => true,
    'support_ecommerce' => true,
    'support_marketplace' => true,
    'manage_remote_plan' => true,
    'settings' => [
        'live_client_id' => [
            'label' => 'PayPal::labels.settings.live_client_id',
            'type' => 'text',
            'required' => false,
        ],
        'live_client_secret' => [
            'label' => 'PayPal::labels.settings.live_client_secret',
            'type' => 'text',
            'required' => false,
        ],
        'live_access_token' => [
            'label' => 'PayPal::labels.settings.live_access_token',
            'type' => 'text',
            'required' => false,
        ],
        'live_access_token_expiry' => [
            'label' => 'PayPal::labels.settings.live_token_expiry',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'PayPal::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_client_id' => [
            'label' => 'PayPal::labels.settings.sandbox_client',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_client_secret' => [
            'label' => 'PayPal::labels.settings.sandbox_secret',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_access_token' => [
            'label' => 'PayPal::labels.settings.sandbox_access_token',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_access_token_expiry' => [
            'label' => 'PayPal::labels.settings.sandbox_token_expiry',
            'type' => 'text',
            'required' => false,
        ],
    ],
    'events' => [
        'PAYMENT.SALE.PENDING' => \Corals\Modules\Payment\PayPal\Job\HandleInvoiceCreated::class,
        'PAYMENT.SALE.COMPLETED' => \Corals\Modules\Payment\PayPal\Job\HandleInvoicePaymentSucceeded::class,
        'PAYMENT.SALE.DENIED' => \Corals\Modules\Payment\PayPal\Job\HandleInvoicePaymentFailed::class,
        'BILLING.SUBSCRIPTION.CANCELLED' => \Corals\Modules\Payment\PayPal\Job\HandleCustomerSubscriptionDeleted::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\PayPal\RestGateway::class,
];