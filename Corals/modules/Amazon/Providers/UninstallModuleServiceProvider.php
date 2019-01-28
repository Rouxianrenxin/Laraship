<?php

namespace Corals\Modules\Amazon\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Amazon\database\migrations\AmazonTables;
use Corals\Modules\Amazon\database\seeds\AmazonDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        AmazonTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        $amazonDatabaseSeeder = new AmazonDatabaseSeeder();

        $amazonDatabaseSeeder->rollback();
    }
}
