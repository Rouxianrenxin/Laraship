<?php

namespace Corals\Modules\LicenceManager\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\LicenceManager\Models\Licence;

class LicenceRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Licence::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Licence::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'licenceable_type' => 'required',
                'licenceable_id' => 'required'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'codes' => 'required'
            ]);
        }

        if ($this->isUpdate()) {
            $licence = $this->route('licence');

            $rules = array_merge($rules, [
                'code' => 'required',
                'status' => 'required'
            ]);
        }

        return $rules;
    }
}
