<?php

namespace Corals\Modules\Ecommerce\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'ecommerce_tags';

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'ecommerce.models.tag';

    protected static $logAttributes = ['name'];

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ecommerce_product_tag');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }
}
