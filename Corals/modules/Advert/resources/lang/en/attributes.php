<?php


return [
    'advertiser' => [
        'name' => 'Name',
        'contact' => 'Contact',
        'email' => 'Email',
        'notes' => 'Notes',
    ],
    'banner' => [
        'name' => 'Name',
        'campaign' => 'Campaign',
        'dimension' => 'Dimension',
        'type' => 'Type',
        'type_options' => [
            'script' => 'Script',
            'media' => 'Media',
            'link' => 'Link'
        ],
        'weight' => 'Weight',
        'notes' => 'Notes',
        'url' => 'URL',
        'zone' => 'Zones',

    ],
    'campaign' => [
        'name' => 'Name',
        'advertiser' => 'Advertiser',
        'starts_at' => 'Starts at',
        'ends_at' => 'Ends at',
        'ends_at_help' => 'If end date not selected; campaign won\'t expire',
        'notes' => 'Notes',
        'weight' => 'Weight',
        'limit_type' => 'Limit Type',
        'limit_type_options' => [
            'impressions' => 'Impressions',
            'clicks' => 'Clicks'
        ],
        'limit_per_day' => 'Limit per day',
        'limit_per_day_help' => '* required if limit type selected',
    ],
    'impression' => [
        'banner_id' => 'Banner',
        'zone_id' => 'Zone',
        'session_id' => 'Session',
        'page_slug' => 'Slug',
        'clicked' => 'Clicked',
        'visitor_details' => 'Details',
    ],
    'website' => [
        'name' => 'Name',
        'url' => 'Url',
        'contact' => 'Contact',
        'email' => 'Email',
        'notes' => 'Notes',
    ],
    'zone' => [
        'name' => 'Name',
        'website' => 'Website',
        'key' => 'Key',
        'dimension' => 'Dimension',
        'notes' => 'Notes',
        'banner' => 'Banners',
        'embed_code' => ' Embed Code',
    ]
];