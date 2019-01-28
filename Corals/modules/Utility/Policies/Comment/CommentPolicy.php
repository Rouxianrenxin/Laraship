<?php

namespace Corals\Modules\Utility\Policies\Comment;

use Corals\User\Models\User;

class CommentPolicy
{
    public function create(User $user)
    {
        return $user->can('Utility::comment.create');
    }

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if (isSuperUser($user)) {
            return true;
        }

        return null;
    }
}
