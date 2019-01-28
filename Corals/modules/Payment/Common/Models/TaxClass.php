<?php

namespace Corals\Modules\Payment\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class TaxClass extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'payment_common.models.tax_class';

    protected static $logAttributes = ['name'];

    protected $casts = [
    ];

    protected $guarded = ['id'];


    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }


    public function getTaxByPriority()
    {
        return $this->taxes()->where('status', 'active')->orderBy('priority', 'desc')->get();
    }


    public function activeTaxes()
    {
        return $this->hasMany(Tax::class)->where('status', 'active');
    }
}
