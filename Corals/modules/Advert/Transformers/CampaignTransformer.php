<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Advert\Models\Campaign;

class CampaignTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('advert.models.campaign.resource_url');

        parent::__construct();
    }

    /**
     * @param Campaign $campaign
     * @return array
     * @throws \Throwable
     */
    public function transform(Campaign $campaign)
    {

        $advertiser_show_url = url(config('advert.models.advertiser.resource_url') . '/' . $campaign->advertiser->hashed_id);

        $show_url = url($this->resource_url, $campaign->hashed_id);

        return [
            'id' => $campaign->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($campaign->name, 50) . '</a>',
            'advertiser' => '<a href="' . $advertiser_show_url . '">' . str_limit($campaign->advertiser->name, 50) . '</a>',
            'notes' => generatePopover($campaign->notes),
            'status' => formatStatusAsLabels($campaign->status),
            'limit_type' => $campaign->limit_type ? ucfirst($campaign->limit_type) : '-',
            'limit_per_day' => $campaign->limit_per_day ? $campaign->limit_per_day : '-',
            'weight' => $campaign->weight,
            'starts_at' => format_date($campaign->starts_at),
            'ends_at' => $campaign->ends_at ? format_date($campaign->ends_at) : 'Don\'t expire.',
            'created_at' => format_date($campaign->created_at),
            'updated_at' => format_date($campaign->updated_at),
            'action' => $this->actions($campaign)
        ];
    }
}