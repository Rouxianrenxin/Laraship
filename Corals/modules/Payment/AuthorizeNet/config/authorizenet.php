<?php

return [
    'name' => 'AuthorizeNet',
    'key' => 'payment_authorizenet',
    'support_subscription' => true,
    'support_ecommerce' => true,
    'manage_remote_plan' => false,
    'support_marketplace' => true,
    'manage_remote_product' => false,
    'manage_remote_sku' => false,
    'manage_remote_order' => false,
    'support_swap' => false,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'capture_payment_method' => false,
    'require_default_payment_set' => false,
    'can_update_payment' => true,
    'create_remote_customer' => true,
    'require_payment_token' => false,

    'settings' => [
        'live_login_id' => [
            'label' => 'AuthorizeNet::labels.settings.live_login_id',
            'type' => 'text',
            'required' => false,
        ],
        'live_transaction_key' => [
            'label' => 'AuthorizeNet::labels.settings.live_transact_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_client_key' => [
            'label' => 'AuthorizeNet::labels.settings.live_client_key',
            'type' => 'text',
            'required' => false,
        ],
        'live_signature' => [
            'label' => 'AuthorizeNet::labels.settings.live_signature',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'AuthorizeNet::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_login_id' => [
            'label' => 'AuthorizeNet::labels.settings.sandbox_login_id',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_transaction_key' => [
            'label' => 'AuthorizeNet::labels.settings.sandbox_transact_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_client_key' => [
            'label' => 'AuthorizeNet::labels.settings.sandbox_client_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_signature' => [
            'label' => 'AuthorizeNet::labels.settings.sandbox_signature',
            'type' => 'text',
            'required' => false,
        ],
    ],
    'events' => [
        'net.authorize.payment.authorization.created' => \Corals\Modules\Payment\AuthorizeNet\Job\HandlePaymentAuthorized::class,
        'net.authorize.payment.authcapture.created' => \Corals\Modules\Payment\AuthorizeNet\Job\HandlePaymentSuccess::class,
        'net.authorize.payment.capture.created' => \Corals\Modules\Payment\AuthorizeNet\Job\HandlePaymentSuccess::class,
        'net.authorize.payment.void.created' => \Corals\Modules\Payment\AuthorizeNet\Job\HandlePaymentFailed::class,
        'net.authorize.customer.subscription.suspended' => \Corals\Modules\Payment\AuthorizeNet\Job\HandleSubscriptionDeleted::class,
        'net.authorize.customer.subscription.terminated' => \Corals\Modules\Payment\AuthorizeNet\Job\HandleSubscriptionDeleted::class,
        'net.authorize.customer.subscription.cancelled' => \Corals\Modules\Payment\AuthorizeNet\Job\HandleSubscriptionDeleted::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\AuthorizeNet\Gateway::class,
];