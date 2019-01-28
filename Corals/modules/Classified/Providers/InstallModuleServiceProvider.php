<?php

namespace Corals\Modules\Classified\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Classified\database\migrations\CreateClassifiedTable;
use Corals\Modules\Classified\database\seeds\ClassifiedDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
        CreateClassifiedTable::class,
    ];

    protected function booted()
    {
        $this->createSchema();

        $classifiedDatabaseSeeder = new ClassifiedDatabaseSeeder();

        $classifiedDatabaseSeeder->run();
    }
}
