<?php

namespace Corals\Settings\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomField extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'settings.models.custom_field';

//    protected static $logAttributes = [];

    protected $casts = [
        'multi_value' => 'json',
    ];

    protected $dates = ['date_value'];

    // value accessor
    protected $appends = ['value'];

    protected $guarded = ['id'];


    public function customFieldSetting()
    {
        return $this->belongsTo(CustomFieldSetting::class, 'field_name', 'name')
            ->where('custom_field_settings.model', $this->attributes['parent_type']);
    }

    /**
     * Return column name for current custom field value
     *
     * @return string
     */
    public function getAttributeName()
    {
        $type = optional($this->customFieldSetting)->type;

        switch ($type) {
            case 'checkbox':
            case 'select':
            case 'text':
            case 'radio':
                $name = 'string_value';
                break;
            case 'textarea':
                $name = 'text_value';
                break;
            case 'date':
                $name = 'date_value';
                break;
            case 'number':
                $name = 'number_value';
                break;
            case 'multi_values':
                $name = 'multi_value';
                break;
            default:
                $name = 'string_value';
        }

        return $name;
    }

    /**
     * Get value for current custom field
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        $attributeName = $this->getAttributeName();
        return $this->$attributeName;
    }

    /**
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function setValueAttribute($value)
    {
        if ($value instanceof self) {
            throw new \Exception(trans('Settings::exception.settings.invalid_custom_attribute'));
        }

        $attributeName = $this->getAttributeName();

        $this->$attributeName = $value;

        return $this;
    }


    /**
     * Return custom field value as string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
