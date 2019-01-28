<?php

namespace Corals\Modules\LicenceManager\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\LicenceManager\database\migrations\LicenceManagerTables;
use Corals\Modules\LicenceManager\database\seeds\LicenceManagerDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        LicenceManagerTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        $licenceManagerDatabaseSeeder = new LicenceManagerDatabaseSeeder();

        $licenceManagerDatabaseSeeder->rollback();
    }
}
