<?php

return [
    'models' => [
        'menu' => [
            'presenter' => \Corals\Menu\Transformers\MenuPresenter::class,
            'resource_url' => 'menu',
            'translatable' => ['name']
        ],
    ]
];