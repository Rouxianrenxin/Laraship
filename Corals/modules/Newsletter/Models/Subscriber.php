<?php

namespace Corals\Modules\Newsletter\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Subscriber extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'newsletter.models.subscriber';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    protected $table = 'newsletter_subscribers';

    public function mailLists()
    {
        return $this->belongsToMany(MailList::class,
            'newsletter_mail_list_subscriber', 'subscriber_id', 'list_id');
    }

    public function emails(){
        return $this->belongsToMany(Email::class,'newsletter_email_logger');
    }


}
