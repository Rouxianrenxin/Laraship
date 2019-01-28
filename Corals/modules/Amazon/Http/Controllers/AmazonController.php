<?php

namespace Corals\Modules\Amazon\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;

use Illuminate\Http\Request;

class AmazonController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function settings(Request $request)
    {
        $this->setViewSharedData(['title_singular' => trans('Amazon::labels.settings.amazon_settings')]);

        $config_setting = config('amazon.settings');
        $settings = [];
        foreach ($config_setting as $key => $setting) {
            $settings['amazon_' . $key] = ['name' => trans('Amazon::labels.settings.' . $key), 'settings' => $setting];

        }
        return view('Amazon::amazon.settings')->with(compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        try {
            $settings = $request->except('_token');

            foreach ($settings as $key => $value) {
                \Settings::set($key, $value, 'Amazon');
            }

            flash(trans('Corals::messages.success.saved', ['item' => trans('Amazon::labels.settings.amazon_settings')]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, 'AmazonSettings', 'savedSettings');
        }

        return redirectTo(url()->previous());
    }
}