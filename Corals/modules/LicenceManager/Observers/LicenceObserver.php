<?php

namespace Corals\Modules\LicenceManager\Observers;

use Corals\Modules\LicenceManager\Models\Licence;

class LicenceObserver
{

    /**
     * @param Licence $licence
     */
    public function created(Licence $licence)
    {
    }
}