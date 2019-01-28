<?php

namespace Corals\Modules\Subscriptions\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Feature extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'subscriptions.models.feature';

    protected static $logAttributes = [
        'name', 'description', 'status'
    ];

    protected $casts = [
        'extras' => 'array'
    ];

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }
}
