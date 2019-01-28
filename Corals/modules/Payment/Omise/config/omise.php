<?php

return [
    'name' => 'Omise',
    'key' => 'payment_omise',
    'support_subscription' => false,
    'support_ecommerce' => true,
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
        'live_public_key' => [
            'label' => 'Omise::labels.settings.live_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_private_key' => [
            'label' => 'Omise::labels.settings.live_private_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'Omise::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_public_key' => [
            'label' => 'Omise::labels.settings.sandbox_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_private_key' => [
            'label' => 'Omise::labels.settings.sandbox_private_key',
            'type' => 'text',
            'required' => false,
        ],
    ],
    'events' => [

        'RECURRING_STOPPED' => \Corals\Modules\Payment\Omise\Job\HandleSubscriptionDeleted::class,
        'RECURRING_INSTALLMENT_SUCCESS' => \Corals\Modules\Payment\Omise\Job\HandleRecurringSuccess::class,
        'RECURRING_INSTALLMENT_FAILED' => \Corals\Modules\Payment\Omise\Job\HandleRecurringFailed::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\Omise\Gateway::class,
];