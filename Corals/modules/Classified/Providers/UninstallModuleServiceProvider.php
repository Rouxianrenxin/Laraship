<?php

namespace Corals\Modules\Classified\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Classified\database\migrations\CreateClassifiedTable;
use Corals\Modules\Classified\database\seeds\ClassifiedDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateClassifiedTable::class,
    ];

    protected function booted()
    {
        $this->dropSchema();

        $classifiedDatabaseSeeder = new ClassifiedDatabaseSeeder();
        
        $classifiedDatabaseSeeder->rollback();
    }
}
