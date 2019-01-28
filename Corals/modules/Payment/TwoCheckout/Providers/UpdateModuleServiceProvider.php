<?php

namespace Corals\Modules\Payment\TwoCheckout\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-twocheckout';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
