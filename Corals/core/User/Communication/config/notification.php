<?php

return [
    'models' => [
        'notification_template' => [
            'presenter' => \Corals\User\Communication\Transformers\NotificationTemplatePresenter::class,
            'resource_url' => 'notification-templates'
        ],
        'notification' => [
            'presenter' => \Corals\User\Communication\Transformers\NotificationPresenter::class,
            'resource_url' => 'notifications'
        ],
    ],
    'supported_channels' => [
        'mail' => 'Notification::labels.supported_channels.mail',
        'database' => 'Notification::labels.supported_channels.database',
//        'slack' => 'Notification::labels.supported_channels.slack',
//        'nexmo' => 'Notification::labels.supported_channels.nexmo',
    ],

    'user_preferences_options' => ['user_preferences' => 'Notification::labels.user_preferences_options.user_preferences']
];