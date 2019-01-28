<?php

namespace Corals\User\Classes;

use Corals\User\Models\User;

class Users
{
    /**
     * Users constructor.
     */
    function __construct()
    {
    }


    /**
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Support\Collection
     */
    public function getUsersList($role = "all")
    {
        $users = User::query();

        if ($role != "all") {
            $users = $users->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $users->get()->pluck('full_name', 'id');

        return $users;
    }

    public function getActiveUsersCount()
    {

        return User::query()->count();

    }

}
