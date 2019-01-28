<?php

return [
    'models' => [
        'product' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\ProductPresenter::class,
            'resource_url' => 'e-commerce/products',
            'default_image' => 'assets/corals/images/default_product_image.png'
        ],
        'coupon' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\CouponPresenter::class,
            'resource_url' => 'e-commerce/coupons',
        ],
        'shipping' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\ShippingPresenter::class,
            'resource_url' => 'e-commerce/shippings',
        ],
        'order' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\OrderPresenter::class,
            'resource_url' => 'e-commerce/orders',
            'statuses' => 'Ecommerce::status.order',
            'shipping_statuses' => 'Ecommerce::status.shipping',
            'payment_statuses' => 'Ecommerce::status.payment',
        ],
        'shop' => [
            'sort_options' => 'Ecommerce::status.shop_order',
        ],
        'wishlist' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\WishlistPresenter::class,
            'resource_url' => 'e-commerce/wishlist',
        ],
        'order_item' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\OrderItemPresenter::class,
        ],
        'category' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\CategoryPresenter::class,
            'resource_url' => 'e-commerce/categories',
            'default_image' => 'assets/corals/images/default_product_image.png'
        ],
        'tag' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\TagPresenter::class,
            'resource_url' => 'e-commerce/tags',
        ],
        'brand' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\BrandPresenter::class,
            'resource_url' => 'e-commerce/brands',
            'default_image' => 'assets/corals/images/default_product_image.png'
        ],
        'attribute' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\AttributePresenter::class,
            'resource_url' => 'e-commerce/attributes',
        ],
        'sku' => [
            'presenter' => \Corals\Modules\Ecommerce\Transformers\SKUPresenter::class,
            'resource_route' => 'e-commerce.products.sku.index',
            'default_image' => 'assets/corals/images/default_product_image.png',
            'inventory_options' => [
                'finite' => 'Ecommerce::attributes.product.type_options.finite',
                'bucket' => 'Ecommerce::attributes.product.type_options.bucket',
                'infinite' => 'Ecommerce::attributes.product.type_options.infinite'
            ],
            'bucket' => [
                'in_stock' => 'Ecommerce::attributes.product.bucket_options.in_stock',
                'out_of_stock' => 'Ecommerce::attributes.product.bucket_options.out_of_stock',
                'limited' => 'Ecommerce::attributes.product.bucket_options.limited',
            ]
        ],
        'sku_property' => [],
    ],
    'settings' => [
        'Company' => [
            'owner' => [
                'label' => 'Ecommerce::labels.settings.company.owner',
                'type' => 'text',
                'required' => true,
            ],
            'name' => [
                'label' => 'Ecommerce::labels.settings.company.name',
                'type' => 'text',
                'required' => true,
            ],
            'street1' => [
                'label' => 'Ecommerce::labels.settings.company.street',
                'type' => 'text',
                'required' => true,
            ],
            'city' => [
                'label' => 'Ecommerce::labels.settings.company.city',
                'type' => 'text',
                'required' => true,
            ],
            'state' => [
                'label' => 'Ecommerce::labels.settings.company.state',
                'type' => 'text',
                'required' => true,
            ],
            'zip' => [
                'label' => 'Ecommerce::labels.settings.company.zip',
                'type' => 'text',
                'required' => true,
            ],
            'country' => [
                'label' => 'Ecommerce::labels.settings.company.country',
                'type' => 'text',
                'required' => true,
            ],
            'phone' => [
                'label' => 'Ecommerce::labels.settings.company.phone',
                'type' => 'text',
                'required' => true,
            ],
            'email' => [
                'label' => 'Ecommerce::labels.settings.company.email',
                'type' => 'text',
                'required' => true,
            ],
        ],
        'Shipping' => [
            'weight_unit' => [
                'label' => 'Ecommerce::labels.settings.shipping.weight_unit',
                'type' => 'select',
                'options' => [
                    'kg' => 'kg',
                    'g' => 'g',
                    'lb' => 'lbs',
                    'oz' => 'oz'
                ],
                'required' => true,
            ],
            'dimensions_unit' => [
                'label' => 'Ecommerce::labels.settings.shipping.dimensions_unit',
                'type' => 'select',
                'options' => [
                    'm' => 'm',
                    'cm' => 'cm',
                    'mm' => 'mm',
                    'in' => 'in',
                    'yd' => 'yd'
                ],
                'required' => true,
            ],
            'shippo_live_token' => [
                'label' => 'Ecommerce::labels.settings.shipping.shippo_live_token',
                'type' => 'text',
                'required' => true,
            ],
            'shippo_test_token' => [
                'label' => 'Ecommerce::labels.settings.shipping.shippo_test_token',
                'type' => 'text',
                'required' => true,
            ],
            'shippo_sandbox_mode' => [
                'label' => 'Ecommerce::labels.settings.shipping.shippo_sandbox_mode',
                'type' => 'boolean'
            ],

        ],
        'Tax' => [
            'calculate_tax' => [
                'label' => 'Ecommerce::labels.settings.tax.calculate_tax',
                'type' => 'boolean',
                'required' => true,
            ]
        ],
        'Rating' => [
            'enable' => [
                'label' => 'Ecommerce::labels.settings.rating.enable',
                'type' => 'boolean',
                'required' => true,
            ]
        ],
        'Wishlist' => [
            'enable' => [
                'label' => 'Ecommerce::labels.settings.wishlist.enable',
                'type' => 'boolean',
                'required' => true,
            ]
        ],
        'Appearance' => [
            'page_limit' => [
                'label' => 'Ecommerce::labels.settings.appearance.page_limit',
                'type' => 'number',
                'required' => false,
            ]
        ],
        'Search' => [
            'title_weight' => [
                'label' => 'Ecommerce::labels.settings.search.title_weight',
                'type' => 'number',
                'step' => 0.01,
                'required' => false,
            ],
            'content_weight' => [
                'label' => 'Ecommerce::labels.settings.search.content_weight',
                'type' => 'number',
                'step' => 0.01,
                'required' => false,
            ],
            'enable_wildcards' => [
                'label' => 'Ecommerce::labels.settings.search.enable_wildcards',
                'type' => 'boolean',
                'required' => true,
            ]
        ],
        'AdditonalCharge' => [
            'additonal_charge_title' => [
                'label' => 'Ecommerce::labels.settings.additonal_charge.title',
                'type' => 'text',
                'required' => false,
            ],
            'additonal_charge_amount' => [
                'label' => 'Ecommerce::labels.settings.additonal_charge.amount',
                'type' => 'number',
                'step' => 0.01,
                'required' => false,
            ],
            'additonal_charge_type' => [
                'label' => 'Ecommerce::labels.settings.additonal_charge.type',
                'type' => 'select',
                'options' => [
                    'fixed' => 'Fixed',
                    'percentage' => 'Percentage',
                ],
                'required' => false,
            ],
            'additonal_charge_gateways' => [
                'label' => 'Ecommerce::labels.settings.additonal_charge.gateways',
                'type' => 'text',
                'required' => false,
            ],
        ]
    ],
];