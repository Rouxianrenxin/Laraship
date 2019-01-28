<?php

namespace Corals\Modules\CMS\Hooks;

class CMS
{
    /**
     * CMS constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $dashboard_content
     * @return string
     * @throws \Throwable
     */
    public function dashboard_content1($dashboard_content)
    {
        if (user()->hasRole('superuser')) {
            $dashboard_content .= view('CMS::partials.dashboard1')->render();
        }

        return $dashboard_content;
    }

    /**
     * @param $dashboard_content
     * @return string
     * @throws \Throwable
     */
    public function dashboard_content2($dashboard_content)
    {
        if (user()->hasRole('superuser')) {
            $dashboard_content .= view('CMS::partials.dashboard2')->render();
        }

        return $dashboard_content;
    }
}