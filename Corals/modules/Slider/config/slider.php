<?php

return [
    'models' => [
        'slider' => [
            'presenter' => \Corals\Modules\Slider\Transformers\SliderPresenter::class,
            'resource_url' => 'slider/sliders',
        ],
        'slide' => [
            'presenter' => \Corals\Modules\Slider\Transformers\SlidePresenter::class,
            'resource_route' => 'sliders.slides.index',
        ]
    ]
];