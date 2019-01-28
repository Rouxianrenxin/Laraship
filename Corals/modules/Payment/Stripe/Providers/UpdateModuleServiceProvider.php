<?php

namespace Corals\Modules\Payment\Stripe\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-stripe';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
