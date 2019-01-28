<?php

namespace Corals\Modules\Amazon\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Ecommerce\Models\Product;
use Spatie\Activitylog\Traits\LogsActivity;

class Import extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'amazon.models.import';

    protected static $logAttributes = [];
    protected $table = 'amazon_imports';

    protected $guarded = ['id'];

    protected $casts = ['keywords' => 'array'];

    public function categories()
    {
        return $this->belongsToMany(AmazonCategory::class, 'amazon_category_import');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'amazon_import_product');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

}
