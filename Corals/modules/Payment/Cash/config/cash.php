<?php

return [
    'name' => 'Cash',
    'key' => 'payment_cash',
    'support_subscription' => true,
    'support_ecommerce' => true,
    'manage_remote_plan' => false,
    'manage_remote_product' => false,
    'manage_remote_sku' => false,
    'manage_remote_order' => false,
    'support_swap' => false,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'capture_payment_method' => false,
    'require_default_payment_set' => false,
    'can_update_payment' => false,
    'create_remote_customer' => false,
    'require_payment_token' => false,
    'default_subscription_status' => 'pending',
    'offline_management' => true,

    'settings' => [
        'cash_notes' => [
            'label' => 'Cash::labels.settings.cash_notes',
            'type' => 'textarea',
            'required' => false,
        ],
    ],
    'events' => [

    ],
    'webhook_handler' => '',
];