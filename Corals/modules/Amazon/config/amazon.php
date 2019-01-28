<?php

return [
    'models' => [
        'import' => [
            'presenter' => \Corals\Modules\Amazon\Transformers\ImportPresenter::class,
            'resource_url' => 'amazon/imports',
        ],
    ],
    'settings' => [
        'api' => [
            'country' => [
                'type' => 'text',
                'label' => 'Amazon::labels.settings.country',
                'required' => true,
                'validation' => null,
                'value' => null,
                'attributes' => [
                    'help_text' => 'Amazon::labels.settings.available_countries'
                ]
            ],
            'access_key' => [
                'type' => 'text',
                'label' => 'Amazon::labels.settings.access_key',
                'required' => true,
                'validation' => '',
                'value' => null,
                'attributes' => [
                    'help_text' => ''
                ]
            ],
            'access_secret' => [
                'type' => 'text',
                'label' => 'Amazon::labels.settings.access_secret',
                'required' => true,
                'validation' => null,
                'value' => null,
                'attributes' => [
                    'help_text' => ''
                ]
            ],
            'associate_tag' => [
                'type' => 'text',
                'label' => 'Amazon::labels.settings.associate_tag',
                'required' => true,
                'validation' => null,
                'value' => null,
                'attributes' => [
                    'help_text' => ''
                ]
            ]
        ]
    ]

];