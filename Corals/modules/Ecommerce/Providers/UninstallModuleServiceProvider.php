<?php

namespace Corals\Modules\Ecommerce\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Ecommerce\database\migrations\CreateEcommerceTable;
use Corals\Modules\Ecommerce\database\migrations\CreateOrdersTable;
use Corals\Modules\Ecommerce\database\seeds\EcommerceDatabaseSeeder;
use Spatie\MediaLibrary\Media;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateEcommerceTable::class,
        CreateOrdersTable::class,
    ];

    protected function booted()
    {
        $this->dropSchema();
        $ecommerceDatabaseSeeder = new EcommerceDatabaseSeeder();
        $ecommerceDatabaseSeeder->rollback();

        Media::whereIn('collection_name',
            ['ecommerce-category-thumbnail', 'ecommerce-brand-thumbnail', 'ecommerce-product-gallery', 'ecommerce-sku-image'])->delete();
    }
}
