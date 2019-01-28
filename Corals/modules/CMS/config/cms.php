<?php

return [
    'models' => [
        'page' => [
            'presenter' => \Corals\Modules\CMS\Transformers\PagePresenter::class,
            'resource_url' => 'cms/pages',
            'translatable' => ['content', 'title', 'meta_keywords', 'meta_description']
        ],
        'post' => [
            'presenter' => \Corals\Modules\CMS\Transformers\PostPresenter::class,
            'resource_url' => 'cms/posts',
        ],
        'category' => [
            'presenter' => \Corals\Modules\CMS\Transformers\CategoryPresenter::class,
            'resource_url' => 'cms/categories',
        ],
        'news' => [
            'presenter' => \Corals\Modules\CMS\Transformers\NewsPresenter::class,
            'resource_url' => 'cms/news',
        ],
        'faq' => [
            'presenter' => \Corals\Modules\CMS\Transformers\FaqPresenter::class,
            'resource_url' => 'cms/faqs',
        ],
        'block' => [
            'presenter' => \Corals\Modules\CMS\Transformers\BlockPresenter::class,
            'resource_url' => 'cms/blocks',
            'translatable' => ['name']
        ],
        'widget' => [
            'presenter' => \Corals\Modules\CMS\Transformers\WidgetPresenter::class,
            'resource_route' => 'blocks.widgets.index',
            'translatable' => ['title', 'content']
        ],
    ],
    'frontend' => [
        'page_limit' => 10,
    ]
];
