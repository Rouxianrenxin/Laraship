<?php

namespace Corals\Modules\Payment\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Payment\Common\database\migrations\CreateTaxablesTable;
use Corals\Modules\Payment\Common\database\migrations\CreateTransactionsTable;
use Corals\Modules\Payment\Common\database\seeds\PaymentDatabaseSeeder;
use Corals\Modules\Payment\database\migrations\CreateCurrencyTable;
use Corals\Modules\Payment\database\migrations\CreateGatewayStatusTable;
use Corals\Modules\Payment\database\migrations\CreateInvoicesTable;
use Corals\Modules\Payment\database\migrations\CreateWebhookCallsTable;
use Corals\Modules\Payment\Common\database\migrations\CreateTaxClassesTable;
use Corals\Modules\Payment\Common\database\migrations\CreateTaxesTable;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{

    protected $migrations = [
        CreateInvoicesTable::class,
        CreateWebhookCallsTable::class,
        CreateGatewayStatusTable::class,
        CreateTaxClassesTable::class,
        CreateTaxesTable::class,
        CreateTaxablesTable::class,
        CreateCurrencyTable::class,
        CreateTransactionsTable::class,
    ];

    protected function booted()
    {
        $this->createSchema();

        $paymentDatabaseSeeder = new PaymentDatabaseSeeder();
        $paymentDatabaseSeeder->run();
    }
}
