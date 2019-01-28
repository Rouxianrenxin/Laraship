<?php

namespace Corals\User\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\User\Models\User;

class UserTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('user.models.user.resource_url');

        parent::__construct();
    }

    /**
     * @param User $user
     * @return array
     * @throws \Throwable
     */
    public function transform(User $user)
    {

        $show_url = url($this->resource_url . '/' . $user->hashed_id);

        $actions = [];

        // prevent user from deleting him self
        if (isSuperUser($user) || user()->id == $user->id) {
            $actions['delete'] = '';
        }

        // prevent not superusers to update superusers
        if (!isSuperUser() && isSuperUser($user)) {
            $actions['edit'] = '';
        }

        return [
            'id' => $user->id,
            'full_name' => $user->full_name,
            'checkbox' => $this->generateCheckboxElement($user),
            'name' => '<a href="' . $show_url . '">' . $user->full_name . '</a>',
            'email' => $user->email,
            'confirmed' => $user->confirmed ? '&#10004;' : '-',
            'roles' => formatArrayAsLabels($user->roles->pluck('label'), 'success'),
            'picture' => $user->picture,
            'picture_thumb' => '<a href="' . $show_url . '">' . '<img src="' . $user->picture_thumb . '" class="img-circle img-responsive" alt="User Picture" width="35"/></a>',
            'created_at' => format_date($user->created_at),
            'updated_at' => format_date($user->updated_at),
            'action' => $this->actions($user, $actions),
        ];
    }
}