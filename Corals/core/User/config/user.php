<?php

return [
    'models' => [
        'user' => [
            'presenter' => \Corals\User\Transformers\UserPresenter::class,
            'resource_url' => 'users',
            'default_picture' => 'assets/corals/images/avatars/',
            'translatable' => ['name']
        ],
        'role' => [
            'presenter' => \Corals\User\Transformers\RolePresenter::class,
            'resource_url' => 'roles'
        ],
    ]
];