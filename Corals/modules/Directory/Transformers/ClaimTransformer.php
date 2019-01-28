<?php

namespace Corals\Modules\Directory\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Directory\Models\Claim;

class ClaimTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('directory.models.claim.resource_url');

        parent::__construct();
    }

    /**
     * @param Claim $claim
     * @return array
     * @throws \Throwable
     */
    public function transform(Claim $claim)
    {
        $listingUrl = url("listings/{$claim->listing->slug}");

        $levels = [
            'pending' => 'info',
            'approved' => 'success',
            'declined' => 'danger',
        ];


        $url = $this->resource_url . '/' . $claim->hashed_id;

        $status = $claim->status;

        $actions = [];

        $actions['edit'] = [
            'href' => '',
            'label' => '',
            'class' => '',
            'data' => []
        ];

        $actions['view'] = [
            'icon' => 'fa fa-fw fa-eye',
            'href' => url($url),
            'label' => trans('Directory::attributes.claim.view'),
            'class' => 'modal-load',
            'data' => [
                'title' => trans('Directory::attributes.claim.listing_claim')
            ],
        ];

        if (user()->can('updateStatus', [$claim, 'declined'])) {

            $actions['declined'] = [
                'icon' => 'fa fa-fw fa-remove',
                'href' => url($url . '/reasons'),
                'label' => trans('Directory::attributes.claim.status_options.declined'),
                'class' => 'modal-load',
                'data' => [
                    'title' => trans('Directory::attributes.claim.status_options.declined'),
                ]

            ];
        }

        if (user()->can('updateStatus', [$claim, 'approved'])) {

            $actions['approved'] = [
                'icon' => 'fa fa-fw fa-check',
                'href' => url($url . '/approved'),
                'label' => trans('Directory::attributes.claim.status_options.approved'),
                'data' => [
                    'action' => "post",
                    'table' => "#ClaimsDataTable"
                ],


            ];
        }

        if (user()->can('updateStatus', [$claim, 'pending'])) {

            $actions['pending'] = [
                'icon' => 'fa fa-clock-o',
                'href' => url($url . '/pending'),
                'label' => trans('Directory::attributes.claim.status_options.pending'),
                'data' => [
                    'action' => "post",
                    'table' => "#ClaimsDataTable"
                ]

            ];
        }

        return [
            'id' => $claim->id,
            'requester' => $claim->user ? "<a href='" . url('users/' . $claim->user->hashed_id) . "'> {$claim->user->name}</a>" : "-",
            'listing' => $claim->listing ? '<a href="' . $listingUrl . '"target="_blank">' . $claim->listing->name . '</a>' : '-',
            'file' => $claim->claim_file ? "<a href='" . $claim->claim_file->getFullUrl() . "'> {$claim->claim_file->file_name}</a>" : "-",
            'status' => formatStatusAsLabels($status, ['level' => $levels[$status], 'text' => trans('Directory::attributes.claim.status_options.' . $status)]),
            'created_at' => format_date($claim->created_at),
            'action' => $this->actions($claim, $actions)
        ];
    }
}
