<?php

return [
    'name' => 'Braintree',
    'key' => 'payment_braintree',
    'support_subscription' => true,
    'support_ecommerce' => true,
    'manage_remote_plan' => false,
    'create_remote_customer' => true,
    'capture_payment_method' => true,
    'require_default_payment_set' => true,
    'support_swap' => true,
    'can_update_payment' => true,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'require_payment_token' => false,

    'settings' => [
        'live_merchant_id' => [
            'label' => 'Braintree::labels.settings.live_merchant_id',
            'type' => 'text',
            'required' => false,
        ],
        'live_public_key' => [
            'label' => 'Braintree::labels.settings.live_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_private_key' => [
            'label' => 'Braintree::labels.settings.live_private_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'Braintree::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_merchant_id' => [
            'label' => 'Braintree::labels.settings.sandbox_merchant_id',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_public_key' => [
            'label' => 'Braintree::labels.settings.sandbox_public_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_private_key' => [
            'label' => 'Braintree::labels.settings.sandbox_private_key',
            'type' => 'text',
            'required' => false,
        ],
    ],
    'events' => [
        'subscription_charged_successfully' => \Corals\Modules\Payment\Braintree\Job\HandleInvoicePaymentSucceeded::class,
        'subscription_charged_unsuccessfully' => \Corals\Modules\Payment\Braintree\Job\HandleInvoicePaymentFailed::class,
        'subscription_canceled' => \Corals\Modules\Payment\Braintree\Job\HandleCustomerSubscriptionDeleted::class,
        'subscription_trial_ended' => \Corals\Modules\Payment\Braintree\Job\HandleCustomerTrialWillEnd::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\Braintree\Gateway::class,
];