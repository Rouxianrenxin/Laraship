<?php

namespace Corals\Modules\Advert\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-advert';
    protected $module_public_path = __DIR__ . '/../public';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
