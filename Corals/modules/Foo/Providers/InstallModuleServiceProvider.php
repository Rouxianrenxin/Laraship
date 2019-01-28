<?php

namespace Corals\Modules\Foo\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Foo\database\migrations\FooTables;
use Corals\Modules\Foo\database\seeds\FooDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';
    
    protected $migrations = [
        FooTables::class
    ];

    protected function booted()
    {
        $this->createSchema();

        $fooDatabaseSeeder = new FooDatabaseSeeder();

        $fooDatabaseSeeder->run();
    }
}
