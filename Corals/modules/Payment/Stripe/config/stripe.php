<?php

return [
    'name' => 'Stripe',
    'key' => 'payment_stripe',
    'support_subscription' => true,
    'support_ecommerce' => true,
    'support_marketplace' => true,
    'manage_remote_plan' => true,
    'manage_remote_product' => false,
    'manage_remote_sku' => false,
    'manage_remote_order' => false,
    'support_swap' => true,
    'supports_swap_in_grace_period' => true,
    'require_invoice_creation' => true,
    'require_plan_activation' => false,
    'capture_payment_method' => false,
    'require_default_payment_set' => false,
    'can_update_payment' => true,
    'create_remote_customer' => true,
    'require_payment_token' => false,

    'settings' => [
        'live_public_key' => [
            'label' => 'Stripe::labels.settings.live_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_secret_key' => [
            'label' => 'Stripe::labels.settings.live_secret',
            'type' => 'text',
            'required' => false,
        ],
        'live_webhook_key' => [
            'label' => 'Stripe::labels.settings.live_webhook',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'Stripe::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_public_key' => [
            'label' => 'Stripe::labels.settings.sandbox_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_secret_key' => [
            'label' => 'Stripe::labels.settings.sandbox_secret',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_webhook_key' => [
            'label' => 'Stripe::labels.settings.sandbox_webhook',
            'type' => 'text',
            'required' => false,
        ],
    ],
    'events' => [
        'invoice.created' => \Corals\Modules\Payment\Stripe\Job\HandleInvoiceCreated::class,
        'invoice.payment_succeeded' => \Corals\Modules\Payment\Stripe\Job\HandleInvoicePaymentSucceeded::class,
        'invoice.payment_failed' => \Corals\Modules\Payment\Stripe\Job\HandleInvoicePaymentFailed::class,
        'customer.subscription.deleted' => \Corals\Modules\Payment\Stripe\Job\HandleCustomerSubscriptionDeleted::class,
        'customer.subscription.trial_will_end' => \Corals\Modules\Payment\Stripe\Job\HandleCustomerTrialWillEnd::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\Stripe\Gateway::class,
];