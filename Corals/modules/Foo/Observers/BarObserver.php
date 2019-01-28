<?php

namespace Corals\Modules\Foo\Observers;

use Corals\Modules\Foo\Models\Bar;

class BarObserver
{

    /**
     * @param Bar $bar
     */
    public function created(Bar $bar)
    {
    }
}