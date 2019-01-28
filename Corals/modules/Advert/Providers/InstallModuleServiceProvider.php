<?php

namespace Corals\Modules\Advert\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Advert\database\migrations\AdvertsTables;
use Corals\Modules\Advert\database\seeds\AdvertDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        AdvertsTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $AdvertDatabaseSeeder = new AdvertDatabaseSeeder();

        $AdvertDatabaseSeeder->run();
    }
}
