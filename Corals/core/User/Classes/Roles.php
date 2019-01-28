<?php

namespace Corals\User\Classes;

use Corals\User\Models\Permission;
use Corals\User\Models\Role;

class Roles
{
    /**
     * Roles constructor.
     */
    function __construct()
    {
    }

    public function getRolesList($options = [])
    {
        $key = $options['key'] ?? 'id';
        $roles = Role::pluck('label', $key);

        return $roles;
    }


    /**
     * @return string
     */
    public function getDashboardUrl()
    {
        $dashboard_url = 'dashboard';

        if (user()) {
            $role = user()->roles()->first();

            if (!empty($role->dashboard_url)) {
                $dashboard_url = $role->dashboard_url;
            }
        }

        return $dashboard_url;
    }

    public function getPermissionsTree()
    {
        $tree = [];

        $permissions = Permission::get();

        foreach ($permissions as $permission) {
            list($package, $model) = explode('::', $permission->name);

            list($model, $action) = explode('.', $model);

            if (!isset($tree[$package])) {
                $tree[$package] = [];
            }
            if (!isset($tree[$package][$model])) {
                $tree[$package][$model] = [];
            }
            $tree[$package][$model][$permission->id] = $action;
        }

        return $tree;
    }
}
