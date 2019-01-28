<?php

namespace Corals\Modules\Directory\Hooks;


class Directory
{

    public function auth_theme($theme)
    {
        return rescue(function () use ($theme) {
            $active_frontend_theme = \Settings::get('active_frontend_theme');
            $directory_auth_theme = \Settings::get('directory_auth_theme');

            if ($directory_auth_theme == $active_frontend_theme) {
                return $directory_auth_theme;
            }
            return $theme;
        }, function () use ($theme) {
            return $theme;
        });
    }

    public function auth_redirect_to($redirectTo)
    {
        if (!$redirectTo) {
            if (!isSuperUser()) {
                $redirectTo = 'directory/user/dashboard';

            }
        }
        return $redirectTo;
    }

    public function directory_dashboard_url($dshboard_url)
    {
        if (!isSuperUser()) {
            return 'directory/user/dashboard';

        }
        return $dshboard_url;

    }
}