<?php

namespace Corals\Modules\Payment\Braintree\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-braintree';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
