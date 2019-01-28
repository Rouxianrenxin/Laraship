<?php

namespace Corals\Modules\Utility\Http\Requests\Category;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Utility\Models\Category\Attribute;

class AttributeRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Attribute::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Attribute::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'type' => 'required|max:191',
                'label' => 'required|max:191',
                'display_order' => 'required|numeric',
            ]);

            foreach ($this->get('options', []) as $id => $item) {
                $rules = array_merge($rules, [
                    "options.{$id}.option_value" => 'required',
                    "options.{$id}.option_order" => 'required|numeric',
                    "options.{$id}.option_display" => 'required',
                ]);
            }
        }


        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $data = $this->all();

        $data['required'] = $this->get('required', false);
        $data['use_as_filter'] = $this->get('use_as_filter', false);

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
