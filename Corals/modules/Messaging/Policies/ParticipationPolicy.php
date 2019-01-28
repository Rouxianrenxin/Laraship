<?php

namespace Corals\Modules\Messaging\Policies;

use Corals\User\Models\User;
use Corals\Modules\Messaging\Models\Participation;

class ParticipationPolicy
{
    public function updateStatus(User $user, Participation $participation, $status)
    {
        if (!$user->can('Messaging::participation.set_status')) {
            return false;
        }

        switch ($status) {
            case 'read':
                return $participation->canBeRead();
                break;
            case 'unread':
                return $participation->canBeUnRead();
                break;
            case 'important':
                return $participation->canBeImportant();
                break;
            case 'star':
                return $participation->canBeStar();
                break;
            default:
                return false;
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Messaging::participation.view')) {
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
        return $user->can('Messaging::participation.create');
    }

    /**
     * @param User $user
     * @param Participation $participation
     * @return bool
     */
    public function update(User $user, Participation $participation)
    {
        if ($user->can('Messaging::participation.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Participation $participation
     * @return bool
     */
    public function destroy(User $user, Participation $participation)
    {
        if ($user->can('Messaging::participation.delete')) {
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
