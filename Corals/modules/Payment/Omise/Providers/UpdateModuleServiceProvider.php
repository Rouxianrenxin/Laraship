<?php

namespace Corals\Modules\Payment\Omise\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-omise';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
