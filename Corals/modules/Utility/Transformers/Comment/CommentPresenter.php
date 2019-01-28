<?php

namespace Corals\Modules\Utility\Transformers\Comment;

use Corals\Foundation\Transformers\FractalPresenter;

class CommentPresenter extends FractalPresenter
{

    /**
     * @return CommentTransformer
     */
    public function getTransformer()
    {
        return new CommentTransformer();
    }
}