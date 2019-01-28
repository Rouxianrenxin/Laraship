<?php

namespace Corals\Modules\Referral\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-referral';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
