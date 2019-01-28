<?php

namespace Corals\User\Models;

use Corals\Foundation\Traits\Hookable;
use Corals\Foundation\Traits\HashTrait;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HashTrait, Hookable;
}