<?php

namespace Corals\Modules\Announcement\Models;

use Corals\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class AnnouncementTracking extends Model
{
    protected $table = 'announcement_tracking';

    public $timestamps = false;
    protected $casts = [
        'read_at' => 'date',
    ];

    protected $fillable = ['user_id', 'read_at', 'translation_language_code'];

    public function announcement()
    {
        return $this->hasMany(Announcement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
