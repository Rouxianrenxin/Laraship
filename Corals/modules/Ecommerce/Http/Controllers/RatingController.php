<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;


use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Utility\Http\Controllers\Rating\RatingBaseController;

class RatingController extends RatingBaseController
{
    protected function setCommonVariables()
    {
        $this->rateableClass = Product::class;
    }
}