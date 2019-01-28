<?php

namespace Corals\Modules\Advert\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Advert\Models\Website;

class WebsiteTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('advert.models.website.resource_url');

        parent::__construct();
    }

    /**
     * @param Website $website
     * @return array
     * @throws \Throwable
     */
    public function transform(Website $website)
    {
        $show_url = url($this->resource_url . '/' . $website->hashed_id);

        return [
            'id' => $website->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($website->name, 50) . '</a>',
            'url' => '<a href="' . $website->url . '" target="_blank">' . $website->url . '</a>',
            'contact' => $website->contact,
            'email' => $website->email,
            'notes' => generatePopover($website->notes),
            'status' => formatStatusAsLabels($website->status),
            'created_at' => format_date($website->created_at),
            'updated_at' => format_date($website->updated_at),
            'action' => $this->actions($website, [
                'campaigns' => [
                    'icon' => 'fa fa-hand-peace-o fa-fw',
                    'href' => url($this->resource_url . '/' . $website->hashed_id . '/campaigns'),
                    'label' => trans('Advert::module.campaign.title'),
                    'data' => []
                ],
            ])
        ];
    }
}