<?php

namespace Corals\Modules\Ecommerce\Models;

use Corals\Foundation\Models\BaseModel;


use Corals\Foundation\Search\Indexable;
use Corals\Foundation\Search\IndexedRecord;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\CMS\Models\Content;
use Corals\Modules\Ecommerce\Facades\Ecommerce;
use Corals\Modules\Ecommerce\Traits\DownloadableModel;
use Corals\Modules\Payment\Models\TaxClass;
use Corals\Modules\Payment\Traits\GatewayStatusTrait;
use Corals\Modules\Utility\Traits\Wishlist\Wishlistable;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\Filesystem\Filesystem;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use Corals\Modules\Utility\Traits\Rating\ReviewRateable as ReviewRateableTrait;


class Product extends BaseModel implements HasMedia
{
    use Indexable, Sluggable, PresentableTrait, LogsActivity,
        HasMediaTrait, GatewayStatusTrait, DownloadableModel, ReviewRateableTrait, Wishlistable;

    public $galleryMediaCollection = 'ecommerce-product-gallery';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'ecommerce.models.product';

    protected $casts = [
        'properties' => 'array',
        'shipping' => 'array',
        'is_featured' => 'boolean'
    ];

    protected $guarded = [];
    protected $indexContentColumns = ['description', 'caption'];
    protected $indexTitleColumns = ['brand.name', 'name', 'skus.code', 'tags.name', 'tags.slug', 'categories.name'];

    protected $table = 'ecommerce_products';

    protected static $logAttributes = ['name', 'description', 'caption', 'properties'];

    protected static function boot()
    {
        parent::boot();
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function hasProperty($key)
    {
        if (!empty($this->properties) && isset($this->properties[$key])) {
            return true;
        }

        return false;
    }

    public function getImageAttribute()
    {
        $image = asset(config($this->config . '.default_image'));

        $gallery = $this->getMedia($this->galleryMediaCollection);

        foreach ($gallery as $item) {
            if ($item->hasCustomProperty('featured')) {
                $image = $item->getFullUrl();
                break;
            }
        }

        return $image;
    }

    public function sku()
    {
        return $this->hasMany(SKU::class);
    }


    public function getDiscountAttribute()
    {
        $type = $this->attributes['type'] ?? null;

        $discount = 0;

        if ($type === 'simple') {
            $sku = $this->sku->first();
            $discount = optional($sku)->discount;
        }

        return $discount;
    }

    public function getRegularPriceAttribute()
    {
        $type = $this->attributes['type'] ?? null;

        $regularPrice = 0;

        if ($type === 'simple') {
            $sku = $this->sku->first();
            $regularPrice = optional($sku)->regular_price;
        }

        return $regularPrice;
    }

    public function getPriceAttribute()
    {
        $type = $this->attributes['type'] ?? null;

        $price = '-';

        if ($type === 'simple') {
            $sku = $this->sku->first();
            $price = optional($sku)->price;
        } elseif ($type === 'variable') {
            $price = $this->sku->min('price');
        }

        if (empty($price)) {
            $price = '-';
        }

        if ($price != '-') {
            $price = currency($price, \Payments::admin_currency_code(), currency()->getUserCurrency());
        }

        if ($type === 'variable' && $price != '-') {
            $price = '<small style="font-size: 9px">' . trans('Ecommerce::attributes.product.starts_at') . ' </small>' . $price;
        }

        return $price;
    }

    /**
     * @param bool $first
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeSKU($first = false)
    {
        $hasManyRelation = $this->hasMany(SKU::class)->where('ecommerce_sku.status', 'active');

        if ($first) {
            $hasManyRelation = $hasManyRelation->first();
        }

        return $hasManyRelation;
    }

    public function getIsSimpleAttribute()
    {
        return $this->type === 'simple';
    }

    public function scopeVisible($query)
    {
        return $query->where('ecommerce_products.status', '<>', 'deleted');
    }

    public function scopeActive($query)
    {
        return $query->where('ecommerce_products.status', 'active');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'ecommerce_category_product');
    }

    public function activeCategories()
    {
        return $this->categories()->where('ecommerce_categories.status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('ecommerce_products.is_featured', true);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'ecommerce_product_tag');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'ecommerce_product_attributes', 'product_id');
    }

    public function getGlobalOptionsAttribute()
    {
        return $this->attributes()->where('sku_level', false)->get();

    }

    public function getVariationOptionsAttribute()
    {
        return $this->attributes()->where('sku_level', true)->get();

    }

    public function activeTags()
    {
        return $this->tags()->where('ecommerce_tags.status', 'active');
    }

    public function posts()
    {
        return $this->morphToMany(Content::class, 'postable');

    }

    public function indexed_records()
    {
        return $this->hasMany(IndexedRecord::class, 'indexable', 'fulltext_search');

    }

    public function tax_classes()
    {
        return $this->morphToMany(TaxClass::class, 'taxable');
    }

    public function renderProductOptions($type = null, $sku = null, $attributes = [])
    {
        if ($type) {
            $fields = $this->{$type};
        } else {
            $fields = $this->attributes;
        }

        $input = '';

        foreach ($fields as $field) {
            $input .= Ecommerce::renderAttribute($field, $sku, $attributes);
        }

        return $input;
    }

    public function copyFirstMediatoSKU($sku)
    {
        $first_media = $this->getFirstMedia($this->galleryMediaCollection);

        $media_path = $first_media->getPath();

        $temporaryDirectory = new TemporaryDirectory();
        $temporaryDirectory->create();

        $temporaryFile = $temporaryDirectory->path($first_media->file_name);

        app(Filesystem::class)->copyFromMediaLibrary($first_media, $temporaryFile);

        $newMedia = $sku
            ->addMedia($temporaryFile)
            ->usingName($first_media->name)
            ->toMediaCollection('ecommerce-sku-image');
        $newMedia->custom_properties = $first_media->custom_properties;

        $temporaryDirectory->delete();

        return $newMedia;

    }

    public function getShowURL($id = null, $params = [])
    {
        return url('shop/' . $this->slug);
    }

    public function getDisplayReference()
    {
        return $this->name;
    }
}
