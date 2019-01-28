<?php

namespace Corals\Modules\Payment\Common\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Payment\Common\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;


class PaymentsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('payment_common.resource_url');
        $this->title = 'Payment::module.payment.title';
        $this->title_singular = 'Payment::module.payment.title_singular';

        parent::__construct();
    }

    /**
     * @param PaymentRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings(Request $request)
    {
        if (!user()->hasPermissionTo('Payment::settings.update')) {
            abort(403);
        }

        $this->setViewSharedData(['title_singular' => trans('Payment::module.payment_settings.title')]);

        $settings = [];

        foreach (\Payments::getAvailableGateways() as $key => $gateway) {
            $configFile = 'payment_' . strtolower($key);
            if (config($configFile)) {
                $settings[config($configFile . '.key')] = config($configFile);
            }
        }

        return view('Payment::settings')->with(compact('settings'));
    }

    public function saveSettings(PaymentRequest $request)
    {
        if (!user()->hasPermissionTo('Payment::settings.update')) {
            abort(403);
        }


        try {
            $settings = $request->except('_token');

            foreach ($settings as $key => $value) {
                \Settings::set($key, $value, 'Payment');
            }

            flash(trans('Corals::messages.success.saved', ['item' => trans('Payment::module.payment_settings.title')]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, 'PaymentSettings', 'savedSettings');
        }

        return redirectTo($this->resource_url . '/settings');
    }


}