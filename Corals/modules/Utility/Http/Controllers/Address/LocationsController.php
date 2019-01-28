<?php

namespace Corals\Modules\Utility\Http\Controllers\Address;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Utility\DataTables\Address\LocationsDataTable;
use Corals\Modules\Utility\Http\Requests\Address\LocationRequest;
use Corals\Modules\Utility\Models\Address\Location;

class LocationsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('utility.models.location.resource_url');
        $this->title = 'Utility::module.location.title';
        $this->title_singular = 'Utility::module.location.title_singular';

        parent::__construct();
    }

    /**
     * @param LocationRequest $request
     * @param LocationsDataTable $dataTable
     * @return mixed
     */
    public function index(LocationRequest $request, LocationsDataTable $dataTable)
    {
        return $dataTable->render('Utility::address.locations.index');
    }

    /**
     * @param LocationRequest $request
     * @return $this
     */
    public function create(LocationRequest $request)
    {
        $location = new Location();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Utility::address.locations.create_edit')->with(compact('location'));
    }

    /**
     * @param LocationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LocationRequest $request)
    {
        try {
            $data = $request->all();

            $location = Location::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Location::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return Location
     */
    public function show(LocationRequest $request, Location $location)
    {
        return $location;
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return $this
     */
    public function edit(LocationRequest $request, Location $location)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $location->name])]);

        return view('Utility::address.locations.create_edit')->with(compact('location'));
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LocationRequest $request, Location $location)
    {
        try {
            $data = $request->all();

            $location->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Location::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LocationRequest $request, Location $location)
    {
        try {
            $location->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Location::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}