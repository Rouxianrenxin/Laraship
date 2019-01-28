<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Advert\Models\Impression;

class ImpressionTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('advert.models.impression.resource_url');

        parent::__construct();
    }

    /**
     * @param Impression $impression
     * @return array
     * @throws \Throwable
     */
    public function transform(Impression $impression)
    {
        $show_url = url($this->resource_url . '/' . $impression->hashed_id);

        return [
            'id' => $impression->id,
            'banner_id' => $impression->banner->name,
            'zone_id' => $impression->zone->name,
            'session_id' => generatePopover($impression->session_id),
            'page_slug' => $impression->page_slug,
            'clicked' => $impression->clicked ? '<i class="fa fa-check text-success"></i>' : '-',
            'visitor_details' => generatePopover($impression->visitorDetail->formattedDetails()),
            'created_at' => format_date($impression->created_at),
            'updated_at' => format_date($impression->updated_at),
            'action' => '',//$this->actions($impression)
        ];
    }
}