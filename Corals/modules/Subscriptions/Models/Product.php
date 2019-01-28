<?php

namespace Corals\Modules\Subscriptions\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Product extends BaseModel implements HasMedia

{
    use PresentableTrait, LogsActivity, HasMediaTrait;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'subscriptions.models.product';

    protected static $logAttributes = ['name', 'description'];

    protected $appends = ['image'];

    protected $guarded = ['id'];

    protected $casts = [
        'extras' => 'array'
    ];

    public function getImageAttribute()
    {
        $media = $this->getFirstMedia('product-image');
        if ($media) {
            return $media->getUrl();
        } else {
            return asset(config($this->config . '.default_image'));
        }
    }

    public function scopeVisible($query)
    {
        return $query->where('status', '<>', 'deleted');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class)->orderBy('display_order');
    }

    public function activePlans()
    {
        return $this->hasMany(Plan::class)
            ->where('status', 'active')
            ->where('is_visible', true)
            ->orderBy('display_order');
    }

    public function features()
    {
        return $this->hasMany(Feature::class)->orderBy('display_order');
    }

    public function activeFeatures()
    {
        return $this->hasMany(Feature::class)->where('status', 'active')->orderBy('display_order');
    }
}
