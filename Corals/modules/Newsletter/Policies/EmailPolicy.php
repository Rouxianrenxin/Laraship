<?php

namespace Corals\Modules\Newsletter\Policies;

use Corals\Modules\Newsletter\Models\Email;
use Corals\User\Models\User;

class EmailPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Newsletter::email.view')) {
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
        return $user->can('Newsletter::email.create');
    }

    /**
     * @param User $user
     * @param Email $email
     * @return bool
     */
    public function update(User $user, Email $email)
    {
        if ($user->can('Newsletter::email.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Email $email
     * @return bool
     */
    public function destroy(User $user, Email $email)
    {
        if ($user->can('Newsletter::email.delete')) {
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
