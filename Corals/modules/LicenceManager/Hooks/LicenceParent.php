<?php

namespace Corals\Modules\LicenceManager\Hooks;


use Corals\Modules\LicenceManager\Models\Licence;

class LicenceParent
{
    /**
     * Get all of the licences.
     */
    public function licenceList()
    {
        return function () {
            return $this->morphMany(Licence::class, 'parent');
        };
    }
}