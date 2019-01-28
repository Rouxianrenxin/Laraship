<?php

namespace Corals\Settings\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\Cache\Cachable;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Setting extends BaseModel
{
    use PresentableTrait, LogsActivity, Cachable;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'settings.models.setting';

    protected static $logAttributes = ['value'];

    protected $guarded = ['id'];

    protected $casts = [
        'editable' => 'boolean',
        'hidden' => 'boolean'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_slug($value, '_');
    }

    public function getTypeAttribute()
    {
        return $this->attributes['type'] = strtoupper($this->attributes['type']);
    }

    public function getFilePath()
    {
        return config('settings.upload_path') . '/' . $this->attributes['value'];
    }

    public function scopeVisible($query)
    {
        return $query->where('hidden', '=', 0);
    }

    public function getValueAttribute()
    {
        $value = $this->attributes['value'];

        switch ($this->attributes['type']) {
            case 'FILE':
                if (!empty($value)) {
                    return asset($this->getFilePath());
                }
                break;
            case 'SELECT':
                $values = json_decode($value, true);
                if ($values) {
                    return $values;
                } else {
                    return [];
                }
                break;
            case 'BOOLEAN':
                if ($value == 'true') {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'NUMBER':
                return floatval($value);
                break;
        }

        return $value;
    }
}
