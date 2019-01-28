<?php

namespace Corals\Modules\Advert\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Website extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'advert_websites';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'advert.models.website';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function isValid()
    {
        return $this->attributes['status'] == 'active';
    }
}
