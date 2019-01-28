<?php

namespace Corals\Modules\Advert\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Advert\Traits\DimensionModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Zone extends BaseModel
{
    use PresentableTrait, LogsActivity, DimensionModelTrait;

    protected $table = 'advert_zones';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'advert.models.zone';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function banners()
    {
        return $this->belongsToMany(Banner::class, 'advert_banner_zone');
    }

    public function activeBanners()
    {
        return $this->banners()->where('advert_banners.status', 'active');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function isValid()
    {
        return $this->attributes['status'] == 'active' && $this->website->isValid();
    }
}
