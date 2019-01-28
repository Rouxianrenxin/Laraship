<?php

namespace Corals\Modules\Foo\Policies;

use Corals\User\Models\User;
use Corals\Modules\Foo\Models\Bar;

class BarPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Foo::bar.view')) {
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
        return $user->can('Foo::bar.create');
    }

    /**
     * @param User $user
     * @param Bar $bar
     * @return bool
     */
    public function update(User $user, Bar $bar)
    {
        if ($user->can('Foo::bar.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Bar $bar
     * @return bool
     */
    public function destroy(User $user, Bar $bar)
    {
        if ($user->can('Foo::bar.delete')) {
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
