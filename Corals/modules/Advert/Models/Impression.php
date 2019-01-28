<?php

namespace Corals\Modules\Advert\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Impression extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'advert_impressions';

    protected $casts = [
        'clicked' => 'boolean',
        'visitor_details' => 'json'
    ];

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'advert.models.impression';

    protected static $logAttributes = [];

    protected $guarded = ['id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }

    public function visitorDetail()
    {
        return $this->hasOne(VisitorDetail::class);
    }
}
