<?php

namespace Corals\Modules\CMS\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\CMS\database\migrations\AddFeaturedImageLink;
use Corals\Modules\CMS\database\migrations\BlockTables;
use Corals\Modules\CMS\database\migrations\CmsTables;
use Corals\Modules\CMS\database\seeds\CMSDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CmsTables::class,
        AddFeaturedImageLink::class,
        BlockTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $cmsDatabaseSeeder = new CMSDatabaseSeeder();

        $cmsDatabaseSeeder->run();
    }
}
