<?php

namespace Corals\User\Http\Controllers\Auth;

use Corals\Foundation\Http\Controllers\AuthBaseController;
use Corals\User\Facades\TwoFactorAuth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends AuthBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as baseAttemptLogin;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->corals_middleware = ['guest'];
        $this->corals_middleware_except = ['logout'];
        parent::__construct();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     * @throws ValidationException
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->confirmed || !(\Settings::get('confirm_user_registration_email', false))) {
                return $this->baseAttemptLogin($request);
            }

            session([
                'confirmation_user_id' => $user->getKey()
            ]);

            throw ValidationException::withMessages([
                'confirmation' => [
                    trans('User::messages.confirmation.not_confirmed')
                ]
            ]);
        }

        return false;
    }

    /**
     * Send the post-authentication response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, Authenticatable $user)
    {
        if (TwoFactorAuth::isEnabled($user)) {
            return $this->logoutAndRedirectToTokenScreen($request, $user);
        }

        $role = $user->roles()->first();

        if (!$role || $role->disable_login) {
            $this->guard()->logout();

            flash(trans('User::messages.auth.role_cannot_login'), 'warning');

            return redirect('login');
        }

        if (!empty($role->dashboard_theme)) {
            session()->put('dashboard_theme', $role->dashboard_theme);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Generate a redirect response to the two-factor token screen.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function logoutAndRedirectToTokenScreen(Request $request, Authenticatable $user)
    {
        $this->guard()->logout();

        $request->session()->put('authy:auth:id', $user->id);

        return redirect(url('auth/token'));
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        $redirect_to_default = 'dashboard';
        $redirect_to = "";
        if (user()) {
            $role = user()->roles()->first();
            if (!empty($role->redirect_url)) {
                $redirect_to = $role->redirect_url;
            } elseif (!empty($role->dashboard_url)) {
                $redirect_to = $role->dashboard_url;
            }
        }

        $redirect_to = \Filters::do_filter('auth_redirect_to', $redirect_to);

        if (!$redirect_to) {
            $redirect_to = $redirect_to_default;
        }


        return $redirect_to;
    }

    public function showLoginForm($roleName = null)
    {

        $view = 'auth.login';

        if (!empty($roleName)) {
            $roleView = 'auth.login.' . $roleName;
            if (view()->exists($roleView)) {
                $view = $roleView;
            }

        }

        return view($view);
    }
}
