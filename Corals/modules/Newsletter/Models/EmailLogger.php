<?php

namespace Corals\Modules\Newsletter\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class EmailLogger extends BaseModel
{
    use PresentableTrait, LogsActivity,SoftDeletes;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'newsletter.models.email_logger';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    protected $table = 'newsletter_email_logger';

    protected $casts = [
        'is_phone' => 'boolean',
        'is_tablet' => 'boolean',
        'is_desktop' => 'boolean',
        'is_robot' => 'boolean',
        'languages' => 'json',
        'extras' => 'json',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
    public function email()
    {
        return $this->belongsTo(Email::class);
    }

}
