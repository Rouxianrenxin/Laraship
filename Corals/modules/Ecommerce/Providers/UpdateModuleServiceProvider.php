<?php

namespace Corals\Modules\Ecommerce\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-ecommerce';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
