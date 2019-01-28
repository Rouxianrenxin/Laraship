<?php

namespace Corals\Modules\Classified\Models;

use Corals\Foundation\Models\BaseModel;


use Corals\Foundation\Search\Indexable;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Utility\Models\Address\Location;
use Corals\Modules\Utility\Traits\Category\ModelHasCategory;
use Corals\Modules\Utility\Traits\Gallery\ModelHasGallery;
use Corals\Modules\Utility\Traits\Tag\HasTags;
use Corals\Modules\Utility\Traits\Wishlist\Wishlistable;
use Corals\User\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Corals\Modules\Utility\Traits\Rating\ReviewRateable as ReviewRateableTrait;


class Product extends BaseModel implements HasMedia
{
    use Indexable, Sluggable, PresentableTrait, ModelHasGallery,
        LogsActivity, HasMediaTrait, ReviewRateableTrait, Wishlistable, HasTags, ModelHasCategory;

    public $galleryMediaCollection = 'classified-product-gallery';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'classified.models.product';

    protected $casts = [
        'properties' => 'array',
        'is_featured' => 'boolean',
        'price_on_call' => 'boolean'
    ];

    protected $guarded = ['id'];

    protected $indexContentColumns = ['description', 'caption'];

    protected $indexTitleColumns = ['name', 'tags.name', 'tags.slug', 'categories.name'];

    protected $table = 'classified_products';

    protected static $logAttributes = ['name', 'description', 'caption', 'properties'];

    public function getModuleName()
    {
        return 'Classified';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function scopeActive($query)
    {
        return $query->where('classified_products.status', 'active');
    }

    public function scopeByCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    public function scopeByStatus($query, $status)
    {

        return $query->where('status', $status);
    }

    public function scopeAuthUser($query)
    {
        return $query->where('user_id', user()->id);
    }

    public function scopeFeatured($query)
    {
        return $query->where('classified_products.is_featured', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCurrencyAttribute()
    {
        $currency = \Payments::admin_currency_code();

        return $currency;
    }

    public function getCurrencyIconAttribute()
    {
        $currency = $this->currency;

        return 'fa fa-fw fa-' . strtolower($currency);
    }

    public function getShowURL($id = null, $params = [])
    {
        return urlWithParameters("products/{$this->slug}", $params);

    }

    public function getDisplayReference()
    {
        return $this->name;
    }
}
