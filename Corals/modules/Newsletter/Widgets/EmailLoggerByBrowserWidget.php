<?php

namespace Corals\Modules\Newsletter\Widgets;

use ConsoleTVs\Charts\Facades\Charts;

class EmailLoggerByBrowserWidget
{

    function __construct()
    {
    }

    function run($args)
    {
        return rescue(function () use ($args) {
            $email = $args['email'] ?? null;

            if (is_null($email)) {
                return '';
            }

            $query = $email->emailLoggers()->whereNotNull('browser');

            $chart = Charts::database($query->get(), 'pie', 'chartjs')
                ->title(trans('Newsletter::labels.widgets.email_logger_by_browser'))
                ->groupBy('browser', 'browser');

            return $chart->render();
        });
    }
}