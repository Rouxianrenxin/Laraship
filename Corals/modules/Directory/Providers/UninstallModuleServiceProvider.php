<?php

namespace Corals\Modules\Directory\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Directory\database\migrations\CreateDirectoryListingsClaimTable;
use Corals\Modules\Directory\database\migrations\CreateDirectoryTable;
use Corals\Modules\Directory\database\migrations\CreateWishlistsTable;
use Corals\Modules\Directory\database\seeds\DirectoryDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateDirectoryTable::class,
        CreateDirectoryListingsClaimTable::class,

    ];

    protected function booted()
    {
        $this->dropSchema();

        $directoryDatabaseSeeder = new DirectoryDatabaseSeeder();
        
        $directoryDatabaseSeeder->rollback();
    }
}
