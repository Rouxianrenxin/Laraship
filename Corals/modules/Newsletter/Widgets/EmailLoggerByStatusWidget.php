<?php

namespace Corals\Modules\Newsletter\Widgets;

use ConsoleTVs\Charts\Facades\Charts;

class EmailLoggerByStatusWidget
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

            $query = $email->emailLoggers();

            $chart = Charts::database($query->get(), 'pie', 'chartjs')
                ->title(trans('Newsletter::labels.widgets.email_logger_by_status'))
                ->groupBy('status', 'status', trans('Newsletter::attributes.email_logger.status_options'));

            return $chart->render();
        });
    }
}