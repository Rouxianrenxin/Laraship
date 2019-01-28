<?php

namespace Corals\Modules\Utility\Models\Comment;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;

class Comment extends BaseModel
{

    use PresentableTrait;

    /**
     * @var string
     */
    protected $table = 'utility_comments';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility.models.comment';
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->morphTo();
    }

    public function scopeComments($query , $commentable_id,$commentable_type)
    {
        return $query->where('commentable_id', $commentable_id)->where('commentable_type', $commentable_type);
    }

}
