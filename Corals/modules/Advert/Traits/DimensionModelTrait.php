<?php

namespace Corals\Modules\Advert\Traits;


trait DimensionModelTrait
{
    public function getWidthAttribute()
    {
        $dimension = $this->dimension;

        $dimensionsArray = config('advert.dimensions');

        return $dimensionsArray[$dimension]['width'] ?? 0;
    }

    public function getHeightAttribute()
    {
        $dimension = $this->dimension;

        $dimensionsArray = config('advert.dimensions');

        return $dimensionsArray[$dimension]['height'] ?? 0;
    }
}