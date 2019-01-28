<?php

namespace Corals\Modules\Payment\Widgets;

use ConsoleTVs\Charts\Builder\Database;
use ConsoleTVs\Charts\Facades\Charts;
use \Corals\Modules\Payment\Models\Invoice;

class MonthlyRevenueWidget
{

    function __construct()
    {
    }

    function run($args)
    {


        $chart = Charts::database((Invoice::where('status', 'paid')->get()), 'bar', 'chartjs')->dateColumn('due_date')
            ->elementLabel(trans('Payment::labels.widgets.revenue'))
            ->title(trans('Payment::labels.widgets.monthly_revenue'))
            ->aggregateColumn('total', 'sum')
            ->groupByMonth();
        return $chart->render();


    }

}