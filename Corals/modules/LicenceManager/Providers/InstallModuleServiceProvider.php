<?php

namespace Corals\Modules\LicenceManager\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\LicenceManager\database\migrations\LicenceManagerTables;
use Corals\Modules\LicenceManager\database\seeds\LicenceManagerDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
        LicenceManagerTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $licenceManagerDatabaseSeeder = new LicenceManagerDatabaseSeeder();

        $licenceManagerDatabaseSeeder->run();
    }
}
