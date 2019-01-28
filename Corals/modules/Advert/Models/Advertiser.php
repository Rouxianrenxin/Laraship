<?php

namespace Corals\Modules\Advert\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Advertiser extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'advert_advertisers';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'advert.models.advertiser';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }


    public function owner()
    {
        return $this->morphTo();
    }
}
