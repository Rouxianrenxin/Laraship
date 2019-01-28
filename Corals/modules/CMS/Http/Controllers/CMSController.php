<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CMSController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function realTimeVisitors(Request $request)
    {
        $visits = \Analytics::getAnalyticsService()->data_realtime->get('ga:' . config('analytics.view_id'), 'rt:activeVisitors')->totalsForAllResults['rt:activeVisitors'];

        return response()->json(['value' => $visits]);
    }
}