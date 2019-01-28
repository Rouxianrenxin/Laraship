<?php

namespace Corals\Modules\Foo\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Bar extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'foo.models.bar';

    protected static $logAttributes = [];

    protected $guarded = ['id'];
}
