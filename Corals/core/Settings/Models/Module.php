<?php

namespace Corals\Settings\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Module extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'settings.models.module';

//    protected static $logAttributes = [];

    protected $casts = [
        'installed' => 'boolean',
        'enabled' => 'boolean',
    ];

    protected $guarded = ['id'];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeInstalled($query)
    {
        return $query->where('installed', true);
    }
}
