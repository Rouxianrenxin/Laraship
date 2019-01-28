<?php

namespace Corals\Modules\Amazon\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Modules\Ecommerce\Models\Product;
use Spatie\Activitylog\Traits\LogsActivity;

class AmazonCategory extends BaseModel
{
    use  LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'amazon.models.amazon_category';

    protected static $logAttributes = [];
    protected $table = 'amazon_categories';

    protected $guarded = ['id'];

    protected $casts = [];

    public function categories()
    {
        return $this->hasMany(Import::class, 'amazon_category_import');
    }


    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

}
