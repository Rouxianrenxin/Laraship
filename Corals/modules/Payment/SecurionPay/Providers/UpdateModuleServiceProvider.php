<?php

namespace Corals\Modules\Payment\SecurionPay\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-securionpay';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
