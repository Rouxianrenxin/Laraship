<?php

namespace Corals\Modules\Referral\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class ReferralProgram extends BaseModel
{
    use PresentableTrait, LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'referral_program.models.referral_program';

    protected static $logAttributes = ['name'];

    protected $casts = [
        'options' => 'array'
    ];

    protected $guarded = ['id'];

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = str_slug($value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function referral_links()
    {
        return $this->hasMany(ReferralLink::class);
    }


    public function activeReferralLinks()
    {
        return $this->hasMany(ReferralLink::class)->where('status', 'active');
    }
}
