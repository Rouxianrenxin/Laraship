<?php

return [
    'models' => [
        'listing' => [
            'presenter' => \Corals\Modules\Directory\Transformers\ListingPresenter::class,
            'resource_url' => 'directory/listings',
            'sort_options' => 'Directory::status.sort_options',
            'default_image' => 'assets/corals/images/default_listing_image.png',
            'user_resource_url' => 'directory/user/listings',
            'review_resource_url' => 'directory/user/reviews',
        ],
        'claim' => [
            'presenter' => \Corals\Modules\Directory\Transformers\ClaimPresenter::class,
            'resource_url' => 'directory/claims',
        ],
        'wishlist' => [
            'resource_url' => 'directory/wishlist',
        ],
        'invite_friends' => [
            'resource_url' => 'directory/user/invite-friends',
        ]
    ]
];
