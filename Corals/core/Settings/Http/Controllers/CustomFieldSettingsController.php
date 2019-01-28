<?php

namespace Corals\Settings\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Settings\DataTables\CustomFieldsDataTable;
use Corals\Settings\Http\Requests\CustomFieldSettingRequest;
use Corals\Settings\Models\CustomField;
use Corals\Settings\Models\CustomFieldSetting;

class CustomFieldSettingsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('settings.models.custom_field_setting.resource_url');
        $this->title = 'Settings::module.custom_field.title';
        $this->title_singular = 'Settings::module.custom_field.title_singular';

        parent::__construct();
    }

    /**
     * @param CustomFieldSettingRequest $request
     * @param CustomFieldsDataTable $dataTable
     * @return mixed
     */
    public function index(CustomFieldSettingRequest $request, CustomFieldsDataTable $dataTable)
    {
        return $dataTable->render('Settings::custom_fields.index');
    }

    /**
     * @param CustomFieldSettingRequest $request
     * @return $this
     */
    public function create(CustomFieldSettingRequest $request)
    {
        $customFieldSetting = new CustomFieldSetting();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Settings::custom_fields.create_edit')->with(compact('customFieldSetting'));
    }

    /**
     * @param CustomFieldSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CustomFieldSettingRequest $request)
    {
        try {
            $data = $request->all();

            $this->optimizeData($data);

            $customFieldSetting = CustomFieldSetting::create($data);

            $this->clearCache($customFieldSetting);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, CustomFieldSetting::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    protected function optimizeData(&$data)
    {
        if (!in_array($data['type'], ['select', 'radio', 'multi_values'])) {
            $data['options'] = [];
        }

        $data['required'] = array_get($data, 'required', false);
    }

    protected function clearCache($customFieldSetting)
    {
        $cache_key = str_slug($customFieldSetting->model) . '_cf_settings';
        \Cache::forget($cache_key);
        $cache_key = str_slug($customFieldSetting->model) . '_cf_name';
        \Cache::forget($cache_key);
    }

    /**
     * @param CustomFieldSettingRequest $request
     * @param CustomFieldSetting $customFieldSetting
     * @return $this
     */
    public function edit(CustomFieldSettingRequest $request, CustomFieldSetting $customFieldSetting)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $customFieldSetting->name])]);

        return view('Settings::custom_fields.create_edit')->with(compact('customFieldSetting'));
    }

    /**
     * @param CustomFieldSettingRequest $request
     * @param CustomFieldSetting $customFieldSetting
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CustomFieldSettingRequest $request, CustomFieldSetting $customFieldSetting)
    {
        try {
            $data = $request->all();

            $this->optimizeData($data);

            $customFieldSetting->update($data);

            $this->clearCache($customFieldSetting);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, CustomFieldSetting::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CustomFieldSettingRequest $request
     * @param CustomFieldSetting $customFieldSetting
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CustomFieldSettingRequest $request, CustomFieldSetting $customFieldSetting)
    {
        try {
            $this->clearCache($customFieldSetting);

            CustomField::where('field_name', $customFieldSetting->name)->delete();

            $customFieldSetting->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
            log_exception($exception, CustomFieldSetting::class, 'destroy');
        }

        return response()->json($message);
    }
}