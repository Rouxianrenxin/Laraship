<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Advert\Models\Advertiser;

class AdvertiserTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('advert.models.advertiser.resource_url');

        parent::__construct();
    }

    /**
     * @param Advertiser $advertiser
     * @return array
     * @throws \Throwable
     */
    public function transform(Advertiser $advertiser)
    {
        $show_url = url($this->resource_url . '/' . $advertiser->hashed_id);

        return [
            'id' => $advertiser->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($advertiser->name, 50) . '</a>',
            'contact' => $advertiser->contact,
            'email' => $advertiser->email,
            'notes' => generatePopover($advertiser->notes),
            'status' => formatStatusAsLabels($advertiser->status),
            'created_at' => format_date($advertiser->created_at),
            'updated_at' => format_date($advertiser->updated_at),
            'action' => $this->actions($advertiser)
        ];
    }
}