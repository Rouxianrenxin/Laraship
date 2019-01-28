<?php

namespace Corals\Modules\Newsletter\Widgets;

use ConsoleTVs\Charts\Facades\Charts;

class EmailLoggerByDeviceTypeWidget
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

            $query = $email->emailLoggers()->whereNotNull('device_type');

            $chart = Charts::database($query->get(), 'pie', 'chartjs')
                ->title(trans('Newsletter::labels.widgets.email_logger_by_device'))
                ->groupBy('device_type', 'device_type');

            return $chart->render();
        });
    }
}