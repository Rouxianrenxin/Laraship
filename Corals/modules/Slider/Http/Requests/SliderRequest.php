<?php

namespace Corals\Modules\Slider\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Slider\Models\Slider;

class SliderRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Slider::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Slider::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'name' => 'required|max:191',
                'type' => 'required|in:images,videos,html',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'key' => 'required|max:191|unique:sliders,key'
            ]);
        }

        if ($this->isUpdate()) {
            $slider = $this->route('slider');

            $rules = array_merge($rules, [
                'key' => 'required|max:191|unique:sliders,key,' . $slider->id,
            ]);
        }

        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $data = $this->all();

        if (isset($data['key'])) {
            $data['key'] = str_slug($data['key']);
        }

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
