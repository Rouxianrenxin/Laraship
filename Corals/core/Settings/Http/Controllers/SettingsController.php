<?php

namespace Corals\Settings\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Foundation\Traits\FileUploadTrait;
use Corals\Settings\DataTables\SettingsDataTable;
use Corals\Settings\Http\Requests\SettingRequest;
use Corals\Settings\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->resource_url = config('settings.models.setting.resource_url');
        $this->title = 'Settings::module.setting.title';
        $this->title_singular = 'Settings::module.setting.title_singular';

        parent::__construct();
    }

    /**
     * @param SettingRequest $request
     * @param SettingsDataTable $dataTable
     * @return mixed
     */
    public function index(SettingRequest $request, SettingsDataTable $dataTable)
    {
        $actions = $this->generateActions();

        $settingsCategorized = Setting::where('hidden', 0)->get()->groupBy('category');

        return $dataTable->render('Settings::settings.index', compact('actions', 'settingsCategorized'));
    }

    protected function generateActions()
    {
        $types = config('settings.types');

        $actions = [];

        foreach ($types as $key => $label) {
            array_push($actions, [
                'icon' => 'fa fa-fw fa-circle-o',
                'href' => url($this->resource_url . '/create?type=' . $key),
                'label' => $label,
                'data' => []
            ]);
        }

        return $actions;
    }

    /**
     * @param SettingRequest $request
     * @return $this
     */
    public function create(SettingRequest $request)
    {
        $type = $request->type;

        if (!array_key_exists($type, config('settings.types'))) {
            flash('Invalid setting type provided!', 'error');
            return redirect('settings');
        }

        $setting = new Setting();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_setting', ['type' => $type, 'title_singular' => $this->title_singular])]);

        return view('Settings::settings.create')->with(compact('setting', 'type'));
    }

    /**
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SettingRequest $request)
    {
        try {
            $data = $request->all();

            $setting = Setting::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Setting::class, 'store');
        }

        return redirectTo($this->resource_url . '/' . $setting->hashed_id . '/edit');
    }

    /**
     * @param SettingRequest $request
     * @param Setting $setting
     * @return $this
     */
    public function show(SettingRequest $request, Setting $setting)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $setting->label])]);

        return view('Settings::settings.show')->with(compact('setting'));
    }

    /**
     * @param SettingRequest $request
     * @param Setting $setting
     * @return $this
     */
    public function edit(SettingRequest $request, Setting $setting)
    {
        if ($setting->hidden || !$setting->editable) {
            abort(404);
        }

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $setting->label])]);

        $view = 'Settings::settings.edit_view';

        if ($request->ajax()) {
            $view = 'Settings::settings.edit_modal';
        }

        return view($view)->with(compact('setting'));
    }

    /**
     * @param SettingRequest $request
     * @param Setting $setting
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        try {

            if ($setting->type == 'FILE') {
                $this->deleteFile($setting->getFilePath());
                $request = $this->saveFiles($request, config('settings.upload_path'));
            }

            $data = $request->all();

            $setting->update($data);

            $message = [
                'action' => 'redirectTo', 'url' => url($setting->getConfig('resource_url') . '#' . str_slug($setting->category)),
                'level' => 'success', 'message' => trans('Corals::messages.success.updated', ['item' => $this->title_singular])
            ];
        } catch (\Exception $exception) {
            log_exception($exception, Setting::class, 'update');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];

        }

        return response()->json($message);
    }

    /**
     * @param SettingRequest $request
     * @param Setting $setting
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SettingRequest $request, Setting $setting)
    {
        try {
            if ($setting->type == 'FILE') {
                @unlink($setting->value);
            }
            $setting->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Setting::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function fileDownload(Setting $setting)
    {
        if (empty($setting->value)) {
            abort(404);
        }

        return response()->download($setting->getFilePath());
    }

    public function cacheIndex(Request $request)
    {
        if (!user()->hasPermissionTo('Administrations::admin.core')) {
            abort(401);
        }

        $this->setViewSharedData(['title' => 'Cache Management']);

        return view('Settings::cache');
    }

    public function cacheAction(Request $request, $action)
    {
        if (!user()->hasPermissionTo('Administrations::admin.core')) {
            abort(401);
        }

        try {
            if (!in_array($action, array_keys(config('settings.supported_commands', [])))) {
                throw new \Exception(trans('Settings::exception.settings.invalid_command'));
            }

            \Artisan::call($action);

            $message = ['level' => 'success', 'message' => trans('Settings::labels.message.command_execute_success')];
        } catch (\Exception $exception) {
            log_exception($exception, Setting::class, 'cacheAction');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}