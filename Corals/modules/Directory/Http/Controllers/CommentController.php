<?php


namespace Corals\Modules\Directory\Http\Controllers;

use Corals\Modules\Utility\Models\Rating\Rating;
use Corals\Modules\Utility\Http\Controllers\Comment\CommentBaseController;

class CommentController extends CommentBaseController
{
    protected function setCommonVariables()
    {
        $this->commentableClass = Rating::class;
    }

}