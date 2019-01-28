<?php

namespace Corals\Modules\Advert\Http\Controllers;

use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\Advert\Models\Zone;
use Illuminate\Http\Request;

class EmbedController extends PublicBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @param Zone $zone
     * @return string
     * @throws \Throwable
     */
    public function embed(Request $request, Zone $zone)
    {
        \Theme::set(\Settings::get('active_admin_theme', config('themes.corals_admin')));

        \Assets::add(asset('assets/corals/plugins/advert/css/advert.css'));
        \Assets::add(asset('assets/corals/plugins/advert/js/embed.js'));

        $view = 'Advert::zones.render';

        $view_variables = compact('zone');

        return view('layouts.embed')->with(compact('view', 'view_variables'))->render();
    }
}