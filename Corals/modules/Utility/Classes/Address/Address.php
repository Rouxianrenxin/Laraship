<?php

namespace Corals\Modules\Utility\Classes\Address;


use Corals\Modules\Utility\Models\Address\Location;

class Address
{
    /**
     * @param null $module
     * @param bool $objects
     * @param string $status
     * @return \Illuminate\Support\Collection
     */
    public function getLocationsList($module = null, $objects = false, $status = 'active', $orderBy = 'name ASC')
    {
        $locations = Location::query();

        if ($module) {
            $locations->where('module', $module);
        }

        if ($status) {
            $locations->where('status', $status);
        }

        $locations = $locations->orderByRaw($orderBy);


        if ($objects) {
            return $locations->get();
        } else {
            return $locations->pluck('name', 'id');
        }
    }

    public function getLocationsCount($module = null, $status = null)
    {
        $locationsCount = Location::query();

        if ($module) {
            $locationsCount = $locationsCount->where('module', $module);
        }
        if ($status) {
            $locationsCount = $locationsCount->where('status', $status);
        }
        return $locationsCount->count();
    }

}