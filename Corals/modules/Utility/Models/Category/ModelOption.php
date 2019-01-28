<?php

namespace Corals\Modules\Utility\Models\Category;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class ModelOption extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'utility_model_attribute_options';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility.models.model_option';

    protected static $logAttributes = [];


    protected $guarded = ['id'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    /**
     * Get value for current option field
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        $attributeName = $this->getAttributeName();

        $value = $this->$attributeName;

        return $value;
    }

    public function getFormattedValueAttribute()
    {
        $type = optional($this->attribute)->type;

        $value = '';

        switch ($type) {
            case 'checkbox':
                $value = $this->value ? '&#10004;' : '-';
                break;
            case 'text':
            case 'date':
            case 'textarea':
            case 'number':
                $value = $this->value;
                break;
            case 'multi_values':
                $attributeOptions = $this->attribute->options()
                    ->where('attribute_id', $this->attribute->id)
                    ->pluck('number_value')->toArray();

                $options = AttributeOption::query()->whereIn('id', $attributeOptions)->get();

                foreach ($options as $option) {
                    $value .= $option->option_display . ', ';
                }

                $value = trim($value, ', ');

                break;
            case 'select':
            case 'radio':
                $value = $this->value;

                $option = $this->attribute->options()->where('id', $value)->first();

                if ($option) {
                    $value = $option->option_display;
                }
                break;
            default:
                $value = $this->value;
                break;
        }


        return $value;
    }

    /**
     * Return column name for current custom field value
     *
     * @return string
     */
    public function getAttributeName()
    {
        $type = optional($this->attribute)->type;

        switch ($type) {
            case 'checkbox':
            case 'text':
            case 'date':
                $name = 'string_value';
                break;
            case 'textarea':
                $name = 'text_value';
                break;
            case 'number':
            case 'select':
            case 'multi_values':
            case 'radio':
                $name = 'number_value';
                break;
            default:
                $name = 'string_value';
        }

        return $name;
    }

    /**
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function setValueAttribute($value)
    {
        $attributeName = $this->getAttributeName();

        $this->{$attributeName} = $value;

        return $this;
    }
}
