<?php

namespace Corals\Modules\Directory\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Search\Indexable;
use Corals\Foundation\Traits\ModelPropertiesTrait;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Utility\Models\Address\Location;
use Corals\User\Models\User;
use Corals\Modules\Utility\Traits\Gallery\ModelHasGallery;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Corals\Modules\Utility\Traits\Tag\HasTags;
use Corals\Modules\Utility\Traits\Category\ModelHasCategory;
use Corals\Modules\Utility\Traits\Wishlist\Wishlistable;
use Corals\Modules\Utility\Traits\Rating\ReviewRateable as ReviewRateableTrait;
use Corals\Modules\Utility\Traits\Schedules\Scheduleable;


class Listing extends BaseModel implements HasMedia
{
    use Indexable, Sluggable, PresentableTrait, ModelHasGallery, LogsActivity, ModelHasCategory, ModelPropertiesTrait
        , HasTags, HasMediaTrait, ReviewRateableTrait, Wishlistable, Scheduleable;

    public $galleryMediaCollection = 'directory-listing-gallery';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'directory.models.listing';

    protected $casts = [
        'properties' => 'array',
        'is_featured' => 'boolean',
    ];

    public function getModuleName()
    {
        return 'Directory';
    }

    protected $guarded = [];

    protected $indexContentColumns = ['description', 'caption'];

    protected $indexTitleColumns = ['name', 'tags.name', 'tags.slug', 'categories.name'];

    protected $table = 'directory_listings';

    protected static $logAttributes = ['name', 'description', 'caption', 'properties'];

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

    public function scopeVisible($query)
    {
        return $query->where('directory_listings.status', '<>', 'deleted');
    }

    public function scopeActive($query)
    {
        return $query->where('directory_listings.status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('directory_listings.status', 'archived');
    }


    public function scopeFeatured($query)
    {
        return $query->where('directory_listings.is_featured', true)->where('directory_listings.status', 'active');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCalculateDistanceFor($query, $lat, $long, $radius)
    {

        $haversine = "(6371 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(directory_listings.`lat`)) 
                    * cos(radians(directory_listings.`long`) 
                    - radians(" . $long . ")) 
                    + sin(radians(" . $lat . ")) 
                    * sin(radians(directory_listings.`lat`))))";

        return $query->select('*')
            ->selectRaw("{$haversine} AS distance")
            ->whereRaw("{$haversine} < ?", [$radius]);
    }

    public function scopeAuthUser($query)
    {
        return $query->where('user_id', user()->id);
    }


    public function getShowURL($id = null, $params = [])
    {
        return urlWithParameters("listings/{$this->slug}", $params);

    }

    public function getDisplayReference()
    {
        return $this->name;
    }

    public function owner()
    {

        if (!empty($this->user_id)) {
            $user = $this->user;
        } else {
            $user = $this->creator;
        }

        return $user;
    }
}
