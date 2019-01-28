<?php

namespace Corals\Modules\Utility\Traits\Comment;

use Corals\Modules\Utility\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Model;

trait ModelHasComments
{
    public static function bootModelHasComments()
    {
        static::deleted(function (Model $deletedModel) {
            if (schemaHasTable('utility_comments')) {
                $deletedModel->comments()->delete();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo('author');
    }
}
