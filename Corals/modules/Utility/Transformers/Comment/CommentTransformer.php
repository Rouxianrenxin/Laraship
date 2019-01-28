<?php

namespace Corals\Modules\Utility\Transformers\Comment;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Utility\Models\Comment\Comment;

class CommentTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('utility.models.comment.resource_url');

        parent::__construct();
    }

    /**
     * @param Comment $comment
     * @return array
     * @throws \Throwable
     */
    public function transform(Comment $comment)
    {

        $hide_actions = ['edit' => ''];

        $commentable_title = optional($comment->commentable)->title;
        $comment_author = optional($comment->author);
        return [
            'id' => $comment->id,
            'body' => $comment->body ? (($comment->body <= 120) ? $comment->body : str_limit($commentable_title, 120, generatePopover($comment->commentable->title))) : '-',
            'commentable_id' => ($commentable_title <= 30) ? $commentable_title : str_limit($commentable_title, 30, generatePopover($comment->commentable->title)),
            'author_id' => $comment_author->name ? "<a href='" . url('users/' . $comment_author->hashed_id) . "'> {$comment_author->name}</a>" : "-",
            'created_at' => format_date($comment->created_at),
            'action' => $this->actions($comment, $hide_actions)
        ];
    }
}