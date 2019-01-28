<?php

namespace Corals\Modules\CMS\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\CMS\database\migrations\CmsTables;
use Corals\Modules\CMS\database\migrations\BlockTables;
use Corals\Modules\CMS\database\seeds\CMSDatabaseSeeder;
use Corals\Settings\Models\Module;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CmsTables::class,
        BlockTables::class
    ];

    protected function booted()
    {
        $module = Module::where('code', 'corals-cms-slider')->first();
        if ($module && $module->installed) {
            \Modules::uninstall($module);
        }

        $this->dropSchema();

        $cmsDatabaseSeeder = new CMSDatabaseSeeder();
        $cmsDatabaseSeeder->rollback();
    }
}
