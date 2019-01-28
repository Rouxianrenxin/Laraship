<?php

namespace Corals\Modules\Advert\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Advert\Models\Zone;

class ZoneRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Zone::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Zone::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'website_id' => 'required',
                'dimension' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'key' => 'required|max:191|unique:advert_zones,key',
                'name' => 'required|max:191|unique:advert_zones,name'
            ]);
        }

        if ($this->isUpdate()) {
            $zone = $this->route('zone');

            $rules = array_merge($rules, [
                'key' => 'required|max:191|unique:advert_zones,key,' . $zone->id,
                'name' => 'required|max:191|unique:advert_zones,name,' . $zone->id,
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
