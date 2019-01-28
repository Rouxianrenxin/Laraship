<?php

return [
    'models' => [
        'referral_program' => [
            'presenter' => \Corals\Modules\Referral\Transformers\ReferralProgramPresenter::class,
            'resource_url' => 'referral/referral-programs',
        ],
        'referral_link' => [
            'presenter' => \Corals\Modules\Referral\Transformers\ReferralLinkPresenter::class,
            'resource_route' => 'referral-programs.referral-links.index',
        ],
        'referral_relationship' => [
            'presenter' => \Corals\Modules\Referral\Transformers\ReferralRelationshipPresenter::class,
            'resource_route' => 'referral-programs.referral-relationships.index',
        ],
    ]
];