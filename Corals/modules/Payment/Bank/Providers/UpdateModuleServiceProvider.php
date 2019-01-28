<?php

namespace Corals\Modules\Payment\Bank\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-bank';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
