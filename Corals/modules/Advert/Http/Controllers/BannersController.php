<?php

namespace Corals\Modules\Advert\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Advert\DataTables\BannersDataTable;
use Corals\Modules\Advert\Http\Requests\BannerRequest;
use Corals\Modules\Advert\Models\Banner;

class BannersController extends BaseController
{
    protected $excludedRequestParams = ['script', 'media', 'link', 'zones'];

    public function __construct()
    {
        $this->resource_url = config('advert.models.banner.resource_url');

        $this->title = 'Advert::module.banner.title';
        $this->title_singular = 'Advert::module.banner.title_singular';

        parent::__construct();
    }

    /**
     * @param BannerRequest $request
     * @param BannersDataTable $dataTable
     * @return mixed
     */
    public function index(BannerRequest $request, BannersDataTable $dataTable)
    {
        return $dataTable->render('Advert::banners.index');
    }

    /**
     * @param BannerRequest $request
     * @return $this
     */
    public function create(BannerRequest $request)
    {
        $banner = new Banner();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Advert::banners.create_edit')->with(compact('banner'));
    }

    /**
     * @param BannerRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BannerRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            if (in_array($data['type'], ['script', 'link'])) {
                $data['content'] = $request->get($data['type']);
            }

            $banner = Banner::create($data);

            $this->setBannerZones($banner, $request);

            if ($data['type'] === 'media' && $request->hasFile('media')) {
                $this->addMedia($banner, $request);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Banner::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param Banner $banner
     * @param BannerRequest $request
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    protected function addMedia(Banner $banner, BannerRequest $request)
    {
        $banner->addMedia($request->file('media'))
            ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
            ->toMediaCollection($banner->mediaCollectionName);
    }


    public function setBannerZones(Banner $banner, BannerRequest $request)
    {
        $zones = $request->get('zones', []);
        $banner->zones()->sync($zones);
    }

    /**
     * @param BannerRequest $request
     * @param Banner $banner
     * @return Banner
     */
    public function show(BannerRequest $request, Banner $banner)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $banner->name])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $banner->hashed_id . '/edit']);

        $campaign = $banner->campaign;

        return view('Advert::banners.show')->with(compact('banner', 'campaign'));
    }

    /**
     * @param BannerRequest $request
     * @param Banner $banner
     * @return $this
     */
    public function edit(BannerRequest $request, Banner $banner)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $banner->name])]);

        $campaign = $banner->campaign;

        return view('Advert::banners.create_edit')->with(compact('banner', 'campaign'));
    }

    /**
     * @param BannerRequest $request
     * @param Banner $banner
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(BannerRequest $request, Banner $banner)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            if (in_array($data['type'], ['script', 'link'])) {
                $banner->clearMediaCollection($banner->mediaCollectionName);

                $data['content'] = $request->get($data['type']);
            } else {
                $data['content'] = null;
            }

            $banner->update($data);
            $this->setBannerZones($banner, $request);

            if ($data['type'] === 'media' && $request->hasFile('media')) {
                $banner->clearMediaCollection($banner->mediaCollectionName);
                $this->addMedia($banner, $request);
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Banner::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param BannerRequest $request
     * @param Banner $banner
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BannerRequest $request, Banner $banner)
    {
        try {
            $banner->clearMediaCollection($banner->mediaCollectionName);

            $banner->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Banner::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}