<?php

namespace Corals\Modules\Advert\Policies;

use Corals\User\Models\User;
use Corals\Modules\Advert\Models\Campaign;

class CampaignPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        if ($user->can('Advert::campaign.view')) {
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
        return $user->can('Advert::campaign.create');
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function update(User $user, Campaign $campaign)
    {
        if ($user->can('Advert::campaign.update')) {
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param Campaign $campaign
     * @return bool
     */
    public function destroy(User $user, Campaign $campaign)
    {
        if ($user->can('Advert::campaign.delete')) {
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
        if ($user->hasPermissionTo('Administrations::admin.advertiser')) {
            return true;
        }

        return null;
    }
}
