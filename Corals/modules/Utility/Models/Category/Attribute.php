<?php

namespace Corals\Modules\Utility\Models\Category;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Attribute extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'utility_attributes';

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility.models.attribute';

    protected $casts = ['use_as_filter' => 'boolean'];

    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'utility_category_attributes');
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }
}