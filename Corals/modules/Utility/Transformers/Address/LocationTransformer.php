<?php

namespace Corals\Modules\Utility\Transformers\Address;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Utility\Models\Address\Location;

class LocationTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('utility.models.location.resource_url');

        parent::__construct();
    }

    /**
     * @param Location $location
     * @return array
     * @throws \Throwable
     */
    public function transform(Location $location)
    {
        return [
            'id' => $location->id,
            'name' => $location->name,
            'address' => $location->address,
            'lat' => $location->lat,
            'long' => $location->long,
            'zip' => $location->zip,
            'city' => $location->city,
            'state' => $location->state,
            'country' => $location->country,
            'status' => formatStatusAsLabels($location->status),
            'created_at' => format_date($location->created_at),
            'updated_at' => format_date($location->updated_at),
            'action' => $this->actions($location)
        ];
    }
}