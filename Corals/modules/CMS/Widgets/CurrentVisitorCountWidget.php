<?php

namespace Corals\Modules\CMS\Widgets;

use ConsoleTVs\Charts\Facades\Charts;

class CurrentVisitorCountWidget
{

    function __construct()
    {
    }

    function run($args)
    {
        try {
            $chart = Charts::realtime(url('cms/active-users'), 2000, 'gauge', 'justgage')
                ->values([0, 10, 100])
                ->labels(['First', 'Second', 'Third'])
                ->elementLabel(trans('CMS::labels.cms_widget.active'))
                ->interval(120000)
                ->title(trans('CMS::labels.cms_widget.current_visitors'))
                ->valueName('value'); //This determines the json index for the value
            return $chart->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}