<?php

namespace Corals\User\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\User\Models\Role;

class RoleTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('user.models.role.resource_url');

        parent::__construct();
    }

    /**
     * @param Role $role
     * @return array
     * @throws \Throwable
     */
    public function transform(Role $role)
    {
        $super_user_role = \Settings::get('super_user_role_id', 1);

        $actions = [];

        if ($role->id == $super_user_role) {
            $actions['delete'] = '';
            $actions['edit'] = '';
        }

        return [
            'id' => $role->id,
            'name' => $role->name,
            'label' => $role->label,
            'users_count' => $role->users_count,
            'subscription_required' => $role->subscription_required ? '<i class="fa fa-check"></i>' : '-',
            'created_at' => format_date($role->created_at),
            'updated_at' => format_date($role->updated_at),
            'action' => $this->actions($role, $actions)
        ];
    }
}