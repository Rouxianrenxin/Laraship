<?php

namespace Corals\Activity\Models;

use Corals\Foundation\Traits\Hookable;
use Corals\Foundation\Traits\HashTrait;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    use HashTrait, Hookable;
}