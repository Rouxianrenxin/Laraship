<?php

namespace Corals\Modules\Subscriptions\Widgets;

use ConsoleTVs\Charts\Facades\Charts;
use \Corals\Modules\Subscriptions\Models\Subscription;

class SubscriptionRatioWidget
{

    function __construct()
    {
    }

    function run($args)
    {


        $chart = Charts::database((Subscription::all()), 'pie', 'chartjs')
            ->title(trans('Subscriptions::labels.widget.subscription'))
            ->groupBy('plan_id', 'plan.name');
        return $chart->render();


    }

}