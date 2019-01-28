<?php


namespace Corals\Modules\Payment\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $casts = [
        'active' => 'boolean'
    ];

    public $config = 'payment_common.models.currency';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

}