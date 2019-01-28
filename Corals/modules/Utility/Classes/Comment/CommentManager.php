<?php

namespace Corals\Modules\Utility\Classes\Comment;

use Illuminate\Database\Eloquent\Model;
use Corals\Modules\Utility\Models\Comment\Comment as CommentModel;

class CommentManager
{

    protected $instance, $author;

    /**
     * RatingManager constructor.
     * @param $instance
     * @param $author
     */
    public function __construct($instance, $author)
    {
        $this->instance = $instance;
        $this->author = $author;
    }

    /**
     * @param $data
     * @return CommentModel|Model
     */
    public function createComment($data)
    {
        $data = array_merge([
            'commentable_id' => $this->instance->id,
            'commentable_type' => get_class($this->instance),
            'author_id' => $this->author->id,
            'author_type' => get_class($this->author),
        ], $data);

        return CommentModel::create($data);
    }

    /**
     * @param CommentModel $comment
     * @return bool|null
     * @throws \Exception
     */
    public function deleteComment(CommentModel $comment)
    {
        return $comment->delete();
    }

}
