<?php

return [
    'models' => [
        'discussion' => [
            'presenter' => \Corals\Modules\Messaging\Transformers\DiscussionPresenter::class,
            'resource_url' => 'messaging/discussions',
        ],
        'message' => [
            'presenter' => \Corals\Modules\Messaging\Transformers\MessagesPresenter::class,
            'resource_url' => 'messaging/messages',
        ],
        'participation' => [
            'presenter' => \Corals\Modules\Messaging\Transformers\ParticipationPresenter::class,
            'resource_url' => 'messaging/participations',
        ],
    ]
];