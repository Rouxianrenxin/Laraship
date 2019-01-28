<?php

namespace Corals\Modules\Ecommerce\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Traits\Node\SimpleNode;
use Spatie\Activitylog\Traits\LogsActivity;

class Attribute extends BaseModel
{
    use PresentableTrait, LogsActivity, SimpleNode;

    protected $table = 'ecommerce_attributes';

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'ecommerce.models.attribute';

    protected $casts = ['use_as_filter' => 'boolean'];

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }
}
