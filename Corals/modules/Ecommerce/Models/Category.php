<?php

namespace Corals\Modules\Ecommerce\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Traits\Node\SimpleNode;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Category extends BaseModel implements HasMedia
{
    use PresentableTrait, LogsActivity, HasMediaTrait, SimpleNode;

    protected $table = 'ecommerce_categories';

    protected $casts = [
        'is_featured' => 'boolean'
    ];

    public $mediaCollectionName = 'ecommerce-category-thumbnail';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'ecommerce.models.category';

    protected static $logAttributes = ['name', 'slug'];

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ecommerce_category_product');
    }

    public function scopeActive($query)
    {
        return $query->where('ecommerce_categories.status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('ecommerce_categories.is_featured', true);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * @return null|string
     * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
     */
    public function getThumbnailAttribute()
    {
        $media = $this->getFirstMedia($this->mediaCollectionName);

        if ($media) {
            return $media->getFullUrl();
        } else {
            return asset(config($this->config . '.default_image'));
        }
    }
}
