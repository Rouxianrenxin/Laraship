<?php

namespace Corals\Modules\Payment\Providers;

use Corals\Modules\Payment\Models\Invoice;
use Corals\Modules\Payment\Models\Transaction;
use Corals\Modules\Payment\Policies\InvoicePolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PaymentAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

        Invoice::class => InvoicePolicy::class,
        Transaction::class => InvoicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}