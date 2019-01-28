<?php

namespace Corals\Modules\Directory\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Directory\Models\Listing;

class ListingTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('directory.models.listing.resource_url');

        parent::__construct();
    }

    /**
     * @param Listing $listing
     * @return array
     * @throws \Throwable
     */
    public function transform(Listing $listing)
    {
        $actions = [];


        $showUrl = $listing->getShowURL();

        $actions['delete'] = [
            'href' => url($this->resource_url . '/' . $listing->hashed_id),
            'label' => trans('Corals::labels.delete'),
            'data' => [
                'action' => 'delete',
                'page_action' => 'site_reload'
            ]
        ];


        $listingName = $listing->name;
        if ($listing->is_featured) {
            $listingName .= '&nbsp;<i class="fa fa-star text-warning" title="Featured"></i>';
        }
        return [
            'id' => $listing->id,
            'image' => '<a href="' . $showUrl . '">' . '<img src="' . $listing->image . '" class=" img-responsive" alt="Listing Image" style="max-width: 25px;max-height: 25px;"/></a>',
            'name' => '<a href="' . $showUrl . '">' . $listingName . '</a>',
            'plain_name' => $listingName,
            'location' => $listing->location->name,
            'caption' => $listing->caption,
            'status' => formatStatusAsLabels($listing->status, ['text' => trans('Directory::attributes.listing.status_options.' . $listing->status)]),
            'categories' => formatArrayAsLabels($listing->categories->pluck('name'), 'success', '<i class="fa fa-folder-open"></i>'),
            'tags' => generatePopover(formatArrayAsLabels($listing->tags->pluck('name'), 'primary', '<i class="fa fa-tags"></i>')),
            'description' => $listing->description ? generatePopover($listing->description) : '-',
            'options' => formatArrayAsLabels($listing->options ? $listing->options->pluck('label') : ''),
            'user_id' => $listing->user ? '<a href="' . $listing->user->getShowURL() . '">' . $listing->user->name . '</a>' : '',
            'created_at' => format_date($listing->created_at),
            'updated_at' => format_date($listing->updated_at),
            'action' => $this->actions($listing, $actions)
        ];
    }
}