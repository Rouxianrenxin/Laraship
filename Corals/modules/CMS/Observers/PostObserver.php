<?php

namespace Corals\Modules\CMS\Observers;

use Corals\Modules\CMS\Models\Post;

class PostObserver
{

    /**
     * @param Post $post
     */
    public function created(Post $post)
    {
    }
}