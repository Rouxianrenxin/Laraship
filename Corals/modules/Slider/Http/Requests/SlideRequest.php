<?php

namespace Corals\Modules\Slider\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Slider\Models\Slide;

class SlideRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Slide::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Slide::class);
        $rules = parent::rules();

        $slider = $this->route('slider');

        if ($this->isUpdate() || $this->isStore()) {
            switch ($slider->type) {
                case 'html':
                    $rules['content'] = 'required';
                    break;
                case 'videos':
                    $rules['content'] = 'required_without:link|mimes:mp4,m4p,m4v,webm,ogg,mpg,mp2,mpeg,mpe,mpv';
                    break;
                case 'images':
                    $rules['content'] = 'required_without:link|image';
                    break;
            }

            $rules = array_merge($rules, [
                'status' => 'required',
                'name' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $slide = $this->route('slide');

            $rules = array_merge($rules, []);
        }

        return $rules;
    }

    public function attributes()
    {
        $slider = $this->route('slider');

        $attributes = [];

        switch ($slider->type) {
            case 'html':
                $attributes['content'] = 'content';
                break;
            case 'videos':
                $attributes['content'] = 'video';
                break;
            case 'images':
                $attributes['content'] = 'image';
                break;
        }

        return $attributes;
    }
}
