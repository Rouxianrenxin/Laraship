<?php

namespace Corals\Modules\Slider\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Slider\Models\Slider;

class SliderTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('slider.models.slider.resource_url');

        parent::__construct();
    }

    /**
     * @param Slider $slider
     * @return array
     * @throws \Throwable
     */
    public function transform(Slider $slider)
    {
        $show_url = url($this->resource_url . '/' . $slider->hashed_id);

        return [
            'id' => $slider->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($slider->name, 50) . '</a>',
            'key' => $slider->key,
            'type' => ucfirst($slider->type),
            'status' => formatStatusAsLabels($slider->status),
            'created_at' => format_date($slider->created_at),
            'updated_at' => format_date($slider->updated_at),
            'short_code' => $this->getShortcode($slider),
            'action' => $this->actions($slider, [
                'slides' => [
                    'icon' => 'fa fa-fw fa-film',
                    'href' => url($this->resource_url . '/' . $slider->hashed_id . '/slides'),
                    'label' => trans('Slider::module.slide.title'),
                    'data' => []
                ],
            ])
        ];
    }

    protected function getShortcode($slider)
    {
        return '<b id="shortcode_' . $slider->id . '">@slider(' . $slider->key . ')</b> 
                <a href="#" onclick="event.preventDefault();" class="copy-button"
                data-clipboard-target="#shortcode_' . $slider->id . '"><i class="fa fa-clipboard"></i></a>';
    }
}