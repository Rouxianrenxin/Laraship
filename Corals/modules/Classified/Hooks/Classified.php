<?php

namespace Corals\Modules\Classified\Hooks;


class Classified
{

    public function auth_theme($theme)
    {


        return rescue(function () use ($theme) {
            $active_frontend_theme = \Settings::get('active_frontend_theme');
            $classified_auth_theme = \Settings::get('classified_auth_theme');
            if ($classified_auth_theme == $active_frontend_theme) {
                return $classified_auth_theme;
            }

            return $theme;
        }, function () use ($theme) {
            return $theme;
        });
    }

    public function auth_redirect_to($redirectTo)
    {

        if (user()->hasPermissionTo('Administrations::admin.classified')) {
            return 'dashboard';

        } else {
            return 'classified/user/dashboard';

        }
    }
}