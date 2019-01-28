<?php

namespace Corals\Modules\Amazon\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Amazon\database\migrations\AmazonTables;
use Corals\Modules\Amazon\database\seeds\AmazonDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
        AmazonTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $amazonDatabaseSeeder = new AmazonDatabaseSeeder();

        $amazonDatabaseSeeder->run();
    }
}
