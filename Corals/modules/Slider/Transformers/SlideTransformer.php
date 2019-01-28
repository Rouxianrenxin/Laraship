<?php

namespace Corals\Modules\Slider\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Slider\Models\Slide;

class SlideTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('slider.models.slide.resource_route');

        parent::__construct();
    }

    /**
     * @param Slide $slide
     * @return array
     * @throws \Throwable
     */
    public function transform(Slide $slide)
    {
        $url = route($this->resource_route, ['slider' => $slide->slider->hashed_id]);

        return [
            'id' => $slide->id,
            'name' => str_limit($slide->name, 50),
            'status' => formatStatusAsLabels($slide->status),
            'created_at' => format_date($slide->created_at),
            'updated_at' => format_date($slide->updated_at),
            'action' => $this->actions($slide, [], $url)
        ];
    }
}