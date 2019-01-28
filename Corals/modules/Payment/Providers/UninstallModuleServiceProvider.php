<?php

namespace Corals\Modules\Payment\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Payment\Common\database\migrations\CreateTaxablesTable;
use Corals\Modules\Payment\Common\database\migrations\CreateTaxClassesTable;
use Corals\Modules\Payment\Common\database\migrations\CreateTaxesTable;
use Corals\Modules\Payment\Common\database\migrations\CreateTransactionsTable;
use Corals\Modules\Payment\Common\database\seeds\PaymentDatabaseSeeder;
use Corals\Modules\Payment\database\migrations\CreateCurrencyTable;
use Corals\Modules\Payment\database\migrations\CreateGatewayStatusTable;
use Corals\Modules\Payment\database\migrations\CreateInvoicesTable;
use Corals\Modules\Payment\database\migrations\CreateWebhookCallsTable;
use Corals\Settings\Models\Module;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{

    protected $migrations = [
        CreateInvoicesTable::class,
        CreateTransactionsTable::class,
        CreateWebhookCallsTable::class,
        CreateGatewayStatusTable::class,
        CreateTaxClassesTable::class,
        CreateTaxesTable::class,
        CreateTaxablesTable::class,
        CreateCurrencyTable::class
    ];

    protected function booted()
    {
        $this->dropSchema();
        $paymentDatabaseSeeder = new PaymentDatabaseSeeder();
        $paymentDatabaseSeeder->rollback();
    }
}
