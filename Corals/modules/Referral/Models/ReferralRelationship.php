<?php

namespace Corals\Modules\Referral\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;

class ReferralRelationship extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $fillable = ['referral_link_id', 'user_id', 'reward', 'translation_language_code'];

    public function link()
    {
        return $this->belongsTo(ReferralLink::class, 'referral_link_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}