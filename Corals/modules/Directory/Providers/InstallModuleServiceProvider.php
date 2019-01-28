<?php

namespace Corals\Modules\Directory\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Directory\database\migrations\CreateDirectoryTable;
use Corals\Modules\Directory\database\migrations\CreateDirectoryListingsClaimTable;
use Corals\Modules\Directory\database\seeds\DirectoryDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';
    
    protected $migrations = [
        CreateDirectoryTable::class,
        CreateDirectoryListingsClaimTable::class,
    ];

    protected function booted()
    {
        $this->createSchema();

        $directoryDatabaseSeeder = new DirectoryDatabaseSeeder();

        $directoryDatabaseSeeder->run();
    }
}
