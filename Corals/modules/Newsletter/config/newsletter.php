<?php

return [
    'models' => [
        'subscriber' => [
            'presenter' => \Corals\Modules\Newsletter\Transformers\SubscriberPresenter::class,
            'resource_url' => 'newsletter/subscribers',
            'import' => [
                'delimiter' => ','
            ],
        ],
        'mail_list' => [
            'presenter' => \Corals\Modules\Newsletter\Transformers\MailListPresenter::class,
            'resource_url' => 'newsletter/mail-lists',
        ],
        'email' => [
            'presenter' => \Corals\Modules\Newsletter\Transformers\EmailPresenter::class,
            'resource_url' => 'newsletter/emails',
            'status_options' => [
                'sent' => 'Newsletter::attributes.email.status_options.sent',
                'draft' => 'Newsletter::attributes.email.status_options.draft',
                'trash' => 'Newsletter::attributes.email.status_options.trash',
            ],
            'status_level' => [
                'sent' => 'success',
                'draft' => 'default',
                'trash' => 'danger',
            ]
        ],
        'email_logger' => [
            'presenter' => \Corals\Modules\Newsletter\Transformers\EmailLoggerPresenter::class,
            'resource_url' => 'newsletter/email-loggers',
            'status_options' => [
                'draft' => 'Newsletter::attributes.email_logger.status_options.draft',
                'sent' => 'Newsletter::attributes.email_logger.status_options.sent',
                'opened' => 'Newsletter::attributes.email_logger.status_options.opened',
                'failed' => 'Newsletter::attributes.email_logger.status_options.failed'
            ],
            'status_level' => [
                'sent' => 'warning',
                'draft' => 'default',
                'opened' => 'success',
                'failed' => 'danger',
            ]
        ]
    ]
];