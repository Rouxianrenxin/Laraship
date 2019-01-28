<?php


return [
    'feature' => [
        'display_order' => 'Order',
        'id' => 'Id',
        'name' => 'Name',
        'caption' => 'Caption',
        'unit' => 'Unit',
        'type' => 'Type',
        'type_option' =>
            ['quantity' => 'Quantity',
                'text' => 'Text',
                'boolean' => 'Boolean'
            ],
        'description' => 'Description'
    ],
    'plan' => [
        'id' => 'Id',
        'name' => 'Name',
        'name_help' => 'A user friendly name for this plan, which will be displayed in your pricing table.',
        'price' => 'Price',
        'price_help' => 'The cost of this plan, per period',
        'bill_cycle' => 'Bill Cycle',
        'display_order' => 'Display Order',
        'recommended' => 'Recommended',
        'this_free_plan' => 'This is a Free plan',
        'is_visible' => 'Is Visible?',
        'visible_help' => '<br/>Is plan visible in pricing table?',
        'description' => 'Description',
        'free_plan' => 'Free Plan',
        'gateway_status' => 'Gateway Plan Status',
        'code' => 'Code',
        'code_help' => 'A unique identifier for this plan, which will be used for remote subscription plan if needed.
                         e.g. stripe plan it will be created if doesn\'t exist',
        'create_gateway_plan' => 'Create this plan on gateway',
        'bill_frequency' => 'Frequency',
        'bill_cycle_every' => 'Every',
        'every_options' => [
            'week' => 'Week(s)',
            'month' => 'Month(s)',
            'year' => 'Year(s)'
        ],
        'trial_period' => 'Trial Period',
        'period_help' => 'The number of days new customers on this plan should receive a free trial.',
    ],
    'product' => [
        'image' => 'Image',
        'name' => 'Name',
        'short_code' => 'Shortcode',
        'description' => 'Description',
        'require_shipping_address' => 'Require Shipping Address on checkout',
        'clear' => 'Clear current image.'
    ],
    'subscription' => [
        'subscription_reference' => 'Reference',
        'sub_reference' => 'Subscription Reference',
        'product_id' => 'Product',
        'gateway' => 'Gateway',
        'subscription_statuses' => [
            'active' => 'Active',
            'cancelled' => 'Cancelled',
            'pending' => 'Pending'
        ],
        'plans' => 'Plans Required for user to Access this content',
        'plan_id' => 'Plan',
        'user_id' => 'User',
        'trial_ends_at' => 'Trial Ends At',
        'ends_at' => 'Ends At',
        'on_trial' => 'On Trial',
        'description' => 'Description',
        'grace_period' => 'Grace Period',
        'pricing' => 'Pricing',
        'select_payment_method' => 'Please select Payment method',
        'next_billing_at' => 'Next billing at',
    ]


];