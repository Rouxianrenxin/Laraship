<?php

namespace Corals\Modules\Subscriptions\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Subscriptions\database\seeds\SubscriptionsDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        \Corals\Modules\Subscriptions\database\migrations\CreateProductsTable::class,
        \Corals\Modules\Subscriptions\database\migrations\CreateFeaturesTable::class,
        \Corals\Modules\Subscriptions\database\migrations\CreatePlansTable::class,
        \Corals\Modules\Subscriptions\database\migrations\CreateFeaturePlanTable::class,
        \Corals\Modules\Subscriptions\database\migrations\CreateSubscriptionsTable::class,
        \Corals\Modules\Subscriptions\database\migrations\AddExtras::class,
    ];

    protected function booted()
    {
        $this->dropSchema();

        $SubscriptionsDatabaseSeeder = new SubscriptionsDatabaseSeeder();
        $SubscriptionsDatabaseSeeder->rollback();
    }
}
