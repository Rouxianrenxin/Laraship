<?php

namespace Corals\Modules\Classified\Http\Controllers;

use Corals\Modules\Utility\Http\Controllers\Rating\RatingBaseController;
use Corals\User\Models\User;


class RatingController extends RatingBaseController
{
    protected function setCommonVariables()
    {
        $this->rateableClass = User::class;
    }

}