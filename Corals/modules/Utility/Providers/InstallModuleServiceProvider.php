<?php

namespace Corals\Modules\Utility\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Utility\database\migrations\CreateAddressTables;
use Corals\Modules\Utility\database\migrations\CreateCategoryAttributeTables;
use Corals\Modules\Utility\database\migrations\CreateCommentsTable;
use Corals\Modules\Utility\database\migrations\CreateRatingsTable;
use Corals\Modules\Utility\database\migrations\CreateSchedulestsTable;
use Corals\Modules\Utility\database\migrations\CreateTagTables;
use Corals\Modules\Utility\database\migrations\CreateWishlistsTable;
use Corals\Modules\Utility\database\seeds\UtilityDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

    protected $migrations = [
        CreateRatingsTable::class,
        CreateWishlistsTable::class,
        CreateAddressTables::class,
        CreateTagTables::class,
        CreateCategoryAttributeTables::class,
        CreateSchedulestsTable::Class,
        CreateCommentsTable::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $utilityDatabaseSeeder = new UtilityDatabaseSeeder();

        $utilityDatabaseSeeder->run();
    }
}
