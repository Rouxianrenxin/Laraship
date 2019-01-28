<?php

namespace Corals\Modules\CMS\Widgets;

use Analytics;
use ConsoleTVs\Charts\Facades\Charts;
use Spatie\Analytics\Period;

class PageViewsWidget
{

    function __construct()
    {
    }

    function run($args)
    {
        try {
            $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
            $visitors = [];
            $pageviews = [];
            $totalViews = ['labels' => []];

            foreach ($analyticsData as $k => $item) {
                array_push($totalViews['labels'], $item['date']->format('d M'));

                array_push($visitors, $item['visitors']);
                array_push($pageviews, $item['pageViews']);
            }


            $chart = Charts::multi('line', 'chartjs')
                ->title(trans('CMS::labels.cms_widget.google_analytics'))
                ->dataset('Visitors', $visitors)
                ->dataset('PageViews', $pageviews)
                // Setup what the values mean
                ->labels($totalViews['labels']);

            return $chart->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}