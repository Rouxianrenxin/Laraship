<?php

namespace Corals\Modules\Ecommerce\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Ecommerce\database\migrations\CreateEcommerceTable;
use Corals\Modules\Ecommerce\database\migrations\CreateOrdersTable;
use Corals\Modules\Ecommerce\database\seeds\EcommerceDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateEcommerceTable::class,
        CreateOrdersTable::class,
    ];

    protected $module_public_path = __DIR__ . '/../public';

    protected function booted()
    {
        $this->createSchema();

        $ecommerceSeeder = new EcommerceDatabaseSeeder();
        $ecommerceSeeder->run();
    }
}
