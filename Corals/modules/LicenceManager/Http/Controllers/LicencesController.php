<?php

namespace Corals\Modules\LicenceManager\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\LicenceManager\DataTables\LicencesDataTable;
use Corals\Modules\LicenceManager\Http\Requests\LicenceRequest;
use Corals\Modules\LicenceManager\Models\Licence;

class LicencesController extends BaseController
{
    protected $excludedRequestParams = [];

    public function __construct()
    {
        $this->resource_url = config('licence_manager.models.licence.resource_url');

        $this->title = 'LicenceManager::module.licence.title';
        $this->title_singular = 'LicenceManager::module.licence.title_singular';

        parent::__construct();
    }

    /**
     * @param LicenceRequest $request
     * @param LicencesDataTable $dataTable
     * @return mixed
     */
    public function index(LicenceRequest $request, LicencesDataTable $dataTable)
    {
        return $dataTable->render('LicenceManager::licences.index');
    }

    /**
     * @param LicenceRequest $request
     * @return $this
     */
    public function create(LicenceRequest $request)
    {
        $licence = new Licence();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('LicenceManager::licences.create')->with(compact('licence'));
    }

    /**
     * @param LicenceRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LicenceRequest $request)
    {
        try {
            $data['licenceable_id'] = $request->get('licenceable_id');
            $data['licenceable_type'] = $request->get('licenceable_type');
            $data['expiry_period'] = $request->get('expiry_period', 0);

            $codes = explode("\r\n", $request->get('codes'));

            if (!is_array($codes)) {
                throw new \Exception(trans('LicenceManager::exceptions.licence.invalid_codes_array'));
            }

            foreach ($codes as $code) {
                $data['code'] = $code;
                $licence = Licence::firstOrCreate($data);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Licence::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LicenceRequest $request
     * @param Licence $licence
     * @return Licence
     */
    public function show(LicenceRequest $request, Licence $licence)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $licence->code])]);

        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $licence->hashed_id . '/edit']);

        return view('LicenceManager::licences.show')->with(compact('licence'));
    }

    /**
     * @param LicenceRequest $request
     * @param Licence $licence
     * @return $this
     */
    public function edit(LicenceRequest $request, Licence $licence)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $licence->code])]);

        return view('LicenceManager::licences.edit')->with(compact('licence'));
    }

    /**
     * @param LicenceRequest $request
     * @param Licence $licence
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LicenceRequest $request, Licence $licence)
    {
        try {
            $data = $request->except($this->excludedRequestParams);

            $licence->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Licence::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param LicenceRequest $request
     * @param Licence $licence
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LicenceRequest $request, Licence $licence)
    {
        try {
            $licence->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Licence::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}