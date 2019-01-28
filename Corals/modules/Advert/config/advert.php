<?php

return [
    'models' => [
        'zone' => [
            'presenter' => \Corals\Modules\Advert\Transformers\ZonePresenter::class,
            'resource_url' => 'adverts/zones',
        ],
        'advertiser' => [
            'presenter' => \Corals\Modules\Advert\Transformers\AdvertiserPresenter::class,
            'resource_url' => 'adverts/advertisers',
        ],
        'website' => [
            'presenter' => \Corals\Modules\Advert\Transformers\WebsitePresenter::class,
            'resource_url' => 'adverts/websites',
        ],
        'campaign' => [
            'presenter' => \Corals\Modules\Advert\Transformers\CampaignPresenter::class,
            'resource_url' => 'adverts/campaigns',
            'limit_types' => [
                'impressions' => 'Advert::attributes.campaign.limit_type_options.impressions',
                'clicks' => 'Advert::attributes.campaign.limit_type_options.clicks'
            ]
        ],
        'impression' => [
            'presenter' => \Corals\Modules\Advert\Transformers\ImpressionPresenter::class,
            'resource_url' => 'adverts/impressions',
        ],
        'visitor_detail' => [
        ],
        'banner' => [
            'presenter' => \Corals\Modules\Advert\Transformers\BannerPresenter::class,
            'resource_url' => 'adverts/banners',
            'types' => [
                'script' => 'Advert::attributes.banner.type_options.script',
                'media' => 'Advert::attributes.banner.type_options.media',
                'link' => 'Advert::attributes.banner.type_options.link'
            ]
        ],
    ],
    'dimensions' => [
        '300x250' => ['width' => 300, 'height' => 250],
        '336x280' => ['width' => 336, 'height' => 280],
        '728x90' => ['width' => 728, 'height' => 90],
        '300x600' => ['width' => 300, 'height' => 600],
        '320x100' => ['width' => 320, 'height' => 100],
        '320x50' => ['width' => 320, 'height' => 50],
        '468x60' => ['width' => 468, 'height' => 60],
        '234x60' => ['width' => 234, 'height' => 60],
        '120x600' => ['width' => 120, 'height' => 600],
        '120x240' => ['width' => 120, 'height' => 240],
        '160x600' => ['width' => 160, 'height' => 600],
        '300x1050' => ['width' => 300, 'height' => 1050],
        '970x90' => ['width' => 970, 'height' => 90],
        '970x250' => ['width' => 970, 'height' => 250],
        '250x250' => ['width' => 250, 'height' => 250],
        '200x200' => ['width' => 200, 'height' => 200],
        '180x150' => ['width' => 180, 'height' => 150],
        '125x125' => ['width' => 125, 'height' => 125],
        '240x400' => ['width' => 240, 'height' => 400],
        '980x120' => ['width' => 980, 'height' => 120],
        '250x360' => ['width' => 250, 'height' => 360],
        '930x180' => ['width' => 930, 'height' => 180],
        '580x400' => ['width' => 580, 'height' => 400],
        '750x300' => ['width' => 750, 'height' => 300],
        '750x200' => ['width' => 750, 'height' => 300],
        '750x100' => ['width' => 750, 'height' => 100],
        '120x90' => ['width' => 120, 'height' => 90],
        '120x60' => ['width' => 120, 'height' => 60],
        '88x31' => ['width' => 88, 'height' => 31],
        '120x30' => ['width' => 120, 'height' => 30],
        '230x33' => ['width' => 230, 'height' => 33],
        '728x210' => ['width' => 728, 'height' => 210],
        '720x300' => ['width' => 720, 'height' => 300],
        '500x350' => ['width' => 500, 'height' => 350],
        '550x480' => ['width' => 550, 'height' => 480],
        '94x15' => ['width' => 94, 'height' => 15],
    ],
];