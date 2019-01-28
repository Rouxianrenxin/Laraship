<?php

namespace Corals\Modules\Foo\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Foo\database\migrations\FooTables;
use Corals\Modules\Foo\database\seeds\FooDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        FooTables::class
    ];

    protected function booted()
    {
        $this->dropSchema();

        $fooDatabaseSeeder = new FooDatabaseSeeder();
        
        $fooDatabaseSeeder->rollback();
    }
}
