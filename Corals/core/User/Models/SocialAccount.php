<?php

namespace Corals\User\Models;
use Corals\Foundation\Models\BaseModel;

class SocialAccount extends BaseModel
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}