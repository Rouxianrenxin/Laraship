<?php

namespace Corals\Modules\Referral\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Referral\Models\ReferralProgram;

class ReferralProgramRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(ReferralProgram::class, 'referral_program');

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(ReferralProgram::class, 'referral_program');
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'title' => 'required|max:191',
                'uri' => 'required|max:191',
                'referral_action' => 'required|max:191',
                'description' => 'required',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:referral_programs',
            ]);
        }

        if ($this->isUpdate()) {
            $referral_program = $this->route('referral_program');

            $rules = array_merge($rules, [
                'name' => 'required|unique:referral_programs,name,' . $referral_program->id,
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

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
