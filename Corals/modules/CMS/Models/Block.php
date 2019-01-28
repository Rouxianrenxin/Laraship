<?php

namespace Corals\Modules\CMS\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Block extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'cms.models.block';

    protected static $logAttributes = ['name'];

    protected $guarded = ['id'];

    protected $table = 'cms_blocks';

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = str_slug($value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function widgets()
    {
        return $this->hasMany(Widget::class);
    }

    public function activeWidgets()
    {
        return $this->hasMany(Widget::class)
            ->where('status', 'active')
            ->orderBy('cms_widgets.widget_order', 'asc');
    }
}
