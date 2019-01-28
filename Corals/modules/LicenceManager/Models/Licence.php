<?php

namespace Corals\Modules\LicenceManager\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Licence extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'licence_manager_licences';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'licence_manager.models.licence';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    /**
     * Get all of the licenceable model.
     */
    public function licenceable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the parent model.
     */
    public function parent()
    {
        return $this->morphTo();
    }

    public function getExpirationDateAttribute()
    {
        $expiration_date = trans('LicenceManager::labels.licence.unlimited');
        
        if (!$this->parent) {
            return $expiration_date;
        }
        if ($this->expiry_period === 0) {
            return $expiration_date;
        }

        $expiration_date = $this->parent->created_at->addMonths($this->expiry_period);

        return format_date($expiration_date);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
