<?php

namespace Corals\User\Http\Controllers;

use Corals\Foundation\Http\Controllers\AuthBaseController;
use Corals\User\Facades\TwoFactorAuth;
use Corals\User\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends AuthBaseController
{
    public function __construct()
    {
        $this->resource_url = 'profile';

        $this->title = 'User::module.profile.title';
        $this->title_singular = 'User::module.profile.title_singular';

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $active_tab = 'profile';
        $active_tab = \Filters::do_filter('active_profile_tab', $active_tab, user());
        return view('auth.profile')->with(compact('active_tab'));
    }

    /**
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProfileRequest $request)
    {
        try {
            $user = user();

            $data = $request->except('clear', 'address', 'profile_image', 'password_confirmation', 'channel', 'two_factor_auth_enabled');

            $data['notification_preferences'] = $request->get('notification_preferences', []);

            if (is_null($data['password'])) {
                unset($data['password']);
            }

            if (TwoFactorAuth::isActive()) {

                if (!TwoFactorAuth::isRegistered($user)) {
                    $user->setAuthPhoneInformation($data['phone_country_code'], $data['phone_number']);
                    $twoFactorOptions = TwoFactorAuth::register($user);
                } else {
                    $twoFactorOptions = $user->getTwoFactorAuthProviderOptions();
                }

                $twoFactorOptions['channel'] = $request->get('channel');
                $twoFactorOptions['enabled'] = $request->get('two_factor_auth_enabled') ? true : false;
                $data['two_factor_options'] = json_encode($twoFactorOptions);
            }

            $user->update($data);

            if (isset($request->profile_image)) {
                $user->clearMediaCollection('user-picture');

                $user->addMediaFromBase64($request->profile_image)->usingFileName('profile.png')
                    ->withCustomProperties(['root' => 'user_' . $user->hashed_id])
                    ->toMediaCollection('user-picture');
            }


            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, 'Profile', 'update');
        }
        return redirectTo('profile');
    }
}