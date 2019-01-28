<?php

namespace Corals\Modules\Payment\PayPal\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-paypal';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
