<?php

namespace Corals\Modules\Messaging\Policies;

use Corals\User\Models\User;
use Corals\Modules\Messaging\Models\Discussion;

class DiscussionPolicy
{
    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Messaging::discussion.view')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->can('Messaging::discussion.create');
    }

    /**
     * @param User $user
     * @param Discussion $discussion
     * @return bool
     */
    public function update(User $user, Discussion $discussion)
    {
        if ($user->can('Messaging::discussion.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Discussion $discussion
     * @return bool
     */
    public function destroy(User $user, Discussion $discussion)
    {
        if ($user->can('Messaging::discussion.delete')) {
            return true;
        }
        return false;
    }

    public function select_recipient(User $user)
    {
        if ($user->can('Messaging::discussion.select_recipient')) {
            return true;
        }
        return false;
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
