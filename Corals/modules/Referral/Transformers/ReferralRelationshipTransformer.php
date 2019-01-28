<?php

namespace Corals\Modules\Referral\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Referral\Models\ReferralRelationship;

class ReferralRelationshipTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('referral_program.models.referral_relationship.resource_route');

        parent::__construct();
    }

    /**
     * @param ReferralRelationship $referralRelationship
     * @return array
     * @throws \Throwable
     */
    public function transform(ReferralRelationship $referralRelationship)
    {
        $url = route($this->resource_route, ['referral_program' => $referralRelationship->link->program->hashed_id]);

        $user_show = config('user.models.user.resource_url');

        if (user()->can('User::user.view')) {
            $link_user = '<a href="' . url($user_show . '/' . $referralRelationship->link->user->hashed_id) . '">' . $referralRelationship->link->user->full_name . '</a>';
            $referral_user = '<a href="' . url($user_show . '/' . $referralRelationship->user->hashed_id) . '">' . $referralRelationship->user->full_name . '</a>';
        } else {
            $link_user = $referralRelationship->link->user->full_name;
            $referral_user = $referralRelationship->user->full_name;
        }

        $actions = ['edit' => ''];

        if (!user()->can('Referral::referral_relationship.destroy')) {
            $actions['delete'] = '';
        }

        return [
            'id' => $referralRelationship->id,
            'program' => $referralRelationship->link->program->title,
            'user' => $link_user,
            'referred_user' => $referral_user,
            'reward' => $referralRelationship->reward,
            'created_at' => format_date($referralRelationship->created_at),
            'updated_at' => format_date($referralRelationship->updated_at),
            'action' => $this->actions($referralRelationship, $actions, $url)
        ];
    }
}