<?php


namespace Corals\Modules\Directory\Http\Controllers;

use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Utility\Http\Controllers\Rating\RatingBaseController;

class RatingController extends RatingBaseController
{
    protected function setCommonVariables()
    {
        $this->rateableClass = Listing::class;
    }


}