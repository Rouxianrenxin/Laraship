<?php

namespace Corals\Modules\Advert\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Advert\DataTables\AdvertiserCampaignsDataTable;
use Corals\Modules\Advert\DataTables\CampaignsDataTable;
use Corals\Modules\Advert\Http\Requests\CampaignRequest;
use Corals\Modules\Advert\Models\Campaign;
use Corals\Modules\Advert\Models\Advertiser;

class CampaignsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('advert.models.campaign.resource_url');

        $this->title = 'Advert::module.campaign.title';
        $this->title_singular = 'Advert::module.campaign.title_singular';

        parent::__construct();
    }

    /**
     * @param CampaignRequest $request
     * @param CampaignsDataTable $dataTable
     * @return mixed
     */
    public function index(CampaignRequest $request, CampaignsDataTable $dataTable)
    {
        return $dataTable->setResourceUrl(url($this->resource_url))->render('Advert::campaigns.index', compact('advertiser'));
    }

    /**
     * @param CampaignRequest $request
     * @return $this
     */
    public function create(CampaignRequest $request)
    {
        $campaign = new Campaign();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Advert::campaigns.create_edit')->with(compact('campaign'));
    }

    /**
     * @param CampaignRequest $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function store(CampaignRequest $request)
    {
        try {
            $data = $request->except('link');


            $campaign = Campaign::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Campaign::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CampaignRequest $request
     * @param Campaign $campaign
     * @return $this
     */
    public function show(CampaignRequest $request, Campaign $campaign)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $campaign->name])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $campaign->hashed_id . '/edit']);

        $advertiser = $campaign->advertiser;

        return view('Advert::campaigns.show')->with(compact('campaign', 'advertiser'));
    }

    /**
     * @param CampaignRequest $request
     * @param Campaign $campaign
     * @return $this
     */
    public function edit(CampaignRequest $request, Campaign $campaign)
    {
        $this->setViewSharedData(['title_singular' =>  trans('Corals::labels.update_title', ['title' => $campaign->name])]);

        $advertiser = $campaign->advertiser;

        return view('Advert::campaigns.create_edit')->with(compact('campaign', 'advertiser'));
    }

    /**
     * @param CampaignRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        try {
            $data = $request->except('link');

            $campaign->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Campaign::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CampaignRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CampaignRequest $request, Campaign $campaign)
    {
        try {
            $campaign->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Campaign::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}