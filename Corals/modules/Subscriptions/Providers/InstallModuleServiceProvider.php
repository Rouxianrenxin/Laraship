<?php

namespace Corals\Modules\Subscriptions\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Subscriptions\database\seeds\SubscriptionsDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $module_public_path = __DIR__ . '/../public';

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
        $this->createSchema();

        $SubscriptionsDatabaseSeeder = new SubscriptionsDatabaseSeeder();
        $SubscriptionsDatabaseSeeder->run();
    }
}
