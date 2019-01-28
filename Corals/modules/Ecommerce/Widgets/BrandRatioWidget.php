<?php

namespace Corals\Modules\Ecommerce\Widgets;

use ConsoleTVs\Charts\Facades\Charts;
use Corals\Modules\Ecommerce\Models\Product;

class BrandRatioWidget
{

    function __construct()
    {
    }

    function run($args)
    {
        $chart = Charts::database((Product::whereNotNull('brand_id')->get()), 'pie', 'chartjs')
            ->title(trans('Ecommerce::labels.widget.products_by_brand'))
            ->groupBy('brand_id', 'brand.name');
        return $chart->render();
    }

}