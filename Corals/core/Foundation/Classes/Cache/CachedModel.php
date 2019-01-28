<?php

namespace Corals\Foundation\Classes\Cache;

use Corals\Foundation\Traits\Cache\Cachable;
use Illuminate\Database\Eloquent\Model;

abstract class CachedModel extends Model
{
    use Cachable;
}
