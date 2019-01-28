<?php

namespace Corals\Settings\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Settings\Models\CustomFieldSetting;

class CustomFieldSettingRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(CustomFieldSetting::class, 'customFieldSetting');

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(CustomFieldSetting::class, 'customFieldSetting');
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'type' => 'required|max:191',
                'model' => 'required|max:191',
                'status' => 'required',
                'options_options.source' => 'required_if:type,select'
            ]);
            if (in_array($this->get('type'), ['select', 'radio', 'multi_values'])) {

                if ($this->get('options_options')['source'] == "static") {
                    foreach ($this->get('options', []) as $id => $item) {
                        $rules = array_merge($rules, [
                            "options.{$id}.key" => 'required',
                            "options.{$id}.value" => 'required',
                        ]);
                    }
                } else if ($this->get('options_options')['source'] == "database") {
                    $rules = array_merge($rules, [
                        "options_options.source_model" => 'required',
                        "options_options.source_model_column" => 'required',
                    ]);

                }

            }


            foreach ($this->get('custom_attributes', []) as $id => $item) {
                $rules = array_merge($rules, [
                    "custom_attributes.{$id}.key" => 'required',
                    "custom_attributes.{$id}.value" => 'required',
                ]);
            }
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, ['name' => 'required|max:191|unique:custom_field_settings,name,null,id,model,' . $this->get('model'),]);
        }

        if ($this->isUpdate()) {
            $customFieldSetting = $this->route('customFieldSetting');
            $rules = array_merge($rules, [
                'name' => "required|max:191|unique:custom_field_settings,name,{$customFieldSetting->id},id,model,{$this->get('model')}",
            ]);
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [];

        foreach ($this->get('options', []) as $id => $item) {
            $attributes["options.{$id}.key"] = 'Key';
            $attributes["options.{$id}.value"] = 'Value';
        }

        foreach ($this->get('custom_attributes', []) as $id => $item) {
            $attributes["custom_attributes.{$id}.key"] = 'Key';
            $attributes["custom_attributes.{$id}.value"] = 'Value';
        }

        return $attributes;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public
    function getValidatorInstance()
    {
        $data = $this->all();

        if (isset($data['name'])) {
            $data['name'] = str_slug($data['name'], '_');
        }

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
