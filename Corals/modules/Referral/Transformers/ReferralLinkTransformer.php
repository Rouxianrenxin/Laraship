<?php

namespace Corals\Modules\Referral\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Referral\Models\ReferralLink;

class ReferralLinkTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('referral_program.models.referral_link.resource_route');

        parent::__construct();
    }

    /**
     * @param ReferralLink $referral_link
     * @return array
     * @throws \Throwable
     */
    public function transform(ReferralLink $referral_link)
    {
        $url = route($this->resource_route, ['referral_program' => $referral_link->program->hashed_id]);

        $show_url = url($url . '/' . $referral_link->hashed_id);

        return [
            'id' => $referral_link->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($referral_link->user->full_name, 50) . '</a>',
            'status' => formatStatusAsLabels($referral_link->status),
            'created_at' => format_date($referral_link->created_at),
            'updated_at' => format_date($referral_link->updated_at),
            'action' => $this->actions($referral_link, [], $url)
        ];
    }
}