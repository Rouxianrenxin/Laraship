<?php

namespace Corals\Modules\Advert\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Campaign extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'advert_campaigns';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'advert.models.campaign';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

}
