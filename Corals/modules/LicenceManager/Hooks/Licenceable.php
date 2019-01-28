<?php

namespace Corals\Modules\LicenceManager\Hooks;


use Corals\Modules\LicenceManager\Models\Licence;

class Licenceable
{
    /**
     * Get all of the licences.
     */
    public function licences()
    {
        return function () {
            return $this->morphMany(Licence::class, 'licenceable');
        };
    }
}