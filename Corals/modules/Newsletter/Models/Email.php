<?php

namespace Corals\Modules\Newsletter\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Email extends BaseModel
{
    use PresentableTrait, LogsActivity, SoftDeletes;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'newsletter.models.email';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    protected $table = 'newsletter_emails';

    protected $casts = [
        'mail_lists' => 'json',
        'subscribers' => 'json',
    ];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'newsletter_email_logger')
            ->withPivot(['api_call_id', 'status', 'failure_message']);
    }

    public function emailLoggers()
    {
        return $this->hasMany(EmailLogger::class);
    }
}
