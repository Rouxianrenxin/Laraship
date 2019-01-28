<?php

return [
    'models' => [
        'subscription' => [
            'presenter' => \Corals\Modules\Subscriptions\Transformers\SubscriptionPresenter::class,
            'resource_url' => 'subscriptions/subscriptions',
            'statuses' => [
                'active' => 'Subscriptions::attributes.subscription.subscription_statuses.active',
                'cancelled' => 'Subscriptions::attributes.subscription.subscription_statuses.cancelled',
                'pending' => 'Subscriptions::attributes.subscription.subscription_statuses.pending'
            ]
        ],
        'product' => [
            'presenter' => \Corals\Modules\Subscriptions\Transformers\ProductPresenter::class,
            'resource_url' => 'subscriptions/products',
            'default_image' => 'assets/corals/images/default_product_image.png',
            'translatable' => ['name']
        ],
        'feature' => [
            'presenter' => \Corals\Modules\Subscriptions\Transformers\FeaturePresenter::class,
            'resource_route' => 'products.features.index',
            'translatable' => ['name', 'caption']
        ],
        'plan' => [
            'presenter' => \Corals\Modules\Subscriptions\Transformers\PlanPresenter::class,
            'resource_route' => 'products.plans.index',
            'translatable' => ['name']
        ],
    ]
];
