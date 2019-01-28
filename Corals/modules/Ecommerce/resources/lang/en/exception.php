<?php

return [
    'coupon' => [
        'not_eligible_use_coupon' => 'You are not eligible to use this coupon code',
        'code_reached_maximum' => 'Coupon code has reached its maximum usage ',
        'must_least_total' => 'You must have at least a total of :amount',
        'max_discount_amount' => 'This has a max discount of :amount',
        'coupon_not_available' => 'This coupon is not available',
        'must_use_discount_amount' => 'You must use a discount amount.',
    ],
    'cart' => [
        'not_find_relation' => 'Could not find relation model',
        'not_find model' => 'Could not find the item model for :arg',
        'item_limited_per_order' => 'This item is limited to :quantity items per order.',
        'quantity_valid_num' => 'The quantity must be a valid number',
        'price_must_valid_num' => 'The price must be a valid number',
        'tax_must_number' => 'The tax must be a number',
        'taxable_option_must_boolean' => 'The taxable option must be a boolean',

    ],
    'misc' => [
        'invalid_gateway' => 'Invalid Gateway Configuration',
        'product_code_exist' => 'Product with code :arg exist in Gateway.',
        'create_gateway' => 'Create Gateway product Failed :message',
        'update_gateway' => 'update Gateway product Failed :message',
        'delete_product' => 'Gateway deleteProduct failed :message',
        'create_gateway_sku' => 'Create Gateway sku Failed :message',
        'update_gateway_sku' => 'update Gateway sku Failed :message',
        'delete_sku' => 'Gateway deleteSKU failed :message',
        'create_order_failed' => 'Create Gateway order Failed :message',
        'invalid_order_code' => 'Invalid Order code :data',
        'update_gateway_order_failed' => 'update Gateway Order Failed :message',
        'order_already_paid' => 'Order is already paid',
        'gateway_create_payment' => 'Gateway createPaymentToken failed :data',
        'least_should_upload' => 'At least one file should be uploaded',
    ],
    'sku' => [
        'item_has_only_quantity' => 'This item has only :quantity quantity available in stock',
        'item_current_out' => 'This item is currently out of stock',
        'invalid_custom' => 'Invalid custom option  value'
    ],
    'checkout' => [
        'invalid_coupon' => 'Invalid Coupon Code',
    ]
];