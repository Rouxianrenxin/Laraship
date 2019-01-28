<?php

namespace Corals\Modules\Advert\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Advert\DataTables\ZonesDataTable;
use Corals\Modules\Advert\Http\Requests\ZoneRequest;
use Corals\Modules\Advert\Models\Zone;

class ZonesController extends BaseController
{
    protected $excludedRequestParams = ['banners'];

    public function __construct()
    {
        $this->resource_url = config('advert.models.zone.resource_url');

        $this->title = 'Advert::module.zone.title';
        $this->title_singular = 'Advert::module.zone.title_singular';

        parent::__construct();
    }

    /**
     * @param ZoneRequest $request
     * @param ZonesDataTable $dataTable
     * @return mixed
     */
    public function index(ZoneRequest $request, ZonesDataTable $dataTable)
    {
        return $dataTable->render('Advert::zones.index');
    }

    /**
     * @param ZoneRequest $request
     * @return $this
     */
    public function create(ZoneRequest $request)
    {
        $zone = new Zone();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Advert::zones.create_edit')->with(compact('zone'));
    }

    /**
     * @param ZoneRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ZoneRequest $request)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $zone = Zone::create($data);

            $this->setZoneBanners($zone, $request);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Zone::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    public function setZoneBanners(Zone $zone, ZoneRequest $request)
    {
        $banners = $request->get('banners', []);

        $zone->banners()->sync($banners);
    }

    /**
     * @param ZoneRequest $request
     * @param Zone $zone
     * @return Zone
     */
    public function show(ZoneRequest $request, Zone $zone)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $zone->name])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $zone->hashed_id . '/edit']);

        $website = $zone->website;

        return view('Advert::zones.show')->with(compact('zone', 'website'));
    }

    /**
     * @param ZoneRequest $request
     * @param Zone $zone
     * @return $this
     */
    public function edit(ZoneRequest $request, Zone $zone)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $zone->name])]);

        $website = $zone->website;

        return view('Advert::zones.create_edit')->with(compact('zone', 'website'));
    }

    /**
     * @param ZoneRequest $request
     * @param Zone $zone
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ZoneRequest $request, Zone $zone)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $zone->update($data);

            $this->setZoneBanners($zone, $request);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Zone::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ZoneRequest $request
     * @param Zone $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ZoneRequest $request, Zone $zone)
    {
        try {
            $zone->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Zone::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}