<?php

namespace Corals\Modules\Newsletter\Policies;

use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\User\Models\User;

class SubscriberPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Newsletter::subscriber.view')) {
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
        return $user->can('Newsletter::subscriber.create');
    }

    /**
     * @param User $user
     * @param Subscriber $subscriber
     * @return bool
     */
    public function update(User $user, Subscriber $subscriber)
    {
        if ($user->can('Newsletter::subscriber.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Subscriber $subscriber
     * @return bool
     */
    public function destroy(User $user, Subscriber $subscriber)
    {
        if ($user->can('Newsletter::subscriber.delete')) {
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
