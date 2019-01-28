<?php

namespace Corals\Modules\Utility\Models\Rating;

use Corals\Foundation\Models\BaseModel;
use Corals\Modules\Utility\Traits\Comment\ModelHasComments;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;

class Rating extends BaseModel
{
    use ModelHasComments, PresentableTrait;
    /**
     * @var string
     */
    protected $table = 'utility_ratings';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility.models.rating';
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reviewrateable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('utility_ratings.status', 'approved');
    }

    public function scopeReviews($query)
    {
        return $query->where('author_id', user()->id)->where('author_type', get_class(user()));
    }

    public function canBePending()
    {
        return in_array($this->status, ['approved', 'disapproved', 'spam']);
    }

    public function canBeApproved()
    {
        return in_array($this->status, ['disapproved', 'pending', 'spam']);
    }

    public function canBeDisApproved()
    {
        return in_array($this->status, ['approved', 'pending', 'spam']);
    }

    public function canBeSpam()
    {
        return in_array($this->status, ['approved', 'pending', 'disapproved']);
    }
}
