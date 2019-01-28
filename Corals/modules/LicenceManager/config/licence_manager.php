<?php

return [
    'models' => [
        'licence' => [
            'presenter' => \Corals\Modules\LicenceManager\Transformers\LicencePresenter::class,
            'resource_url' => 'licences',
            'status_options' => [
                'free' => 'LicenceManager::attributes.licence.status_options.free',
                'reserved' => 'LicenceManager::attributes.licence.status_options.reserved',
                'cancelled' => 'LicenceManager::attributes.licence.status_options.cancelled',
                'invalid' => 'LicenceManager::attributes.licence.status_options.invalid',
                'expired' => 'LicenceManager::attributes.licence.status_options.expired'
            ]
        ],
    ]
];