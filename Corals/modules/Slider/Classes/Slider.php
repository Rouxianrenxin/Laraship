<?php

namespace Corals\Modules\Slider\Classes;

use Corals\Modules\Slider\Models\SliderOptions;

class Slider
{
    /**
     * FooBar constructor.
     */
    function __construct()
    {
    }


    public function getSliderDefaultOptions($hidden = null)
    {

        $options = SliderOptions::whereNotNull('id');

        if (!is_null($hidden)) {
            $options = $options->where('hidden', $hidden);
        }

        $options = $options->get();

        return $options;
    }
}