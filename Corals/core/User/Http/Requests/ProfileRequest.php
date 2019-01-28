<?php

namespace Corals\User\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;

class ProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|max:191|unique:users,email,' . user()->id,
            'password' => 'nullable|confirmed|max:191|min:6',
            'picture' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),

        ];

        $is_two_factor_auth_enabled = \Settings::get('two_factor_auth_enabled', false);

        if ($is_two_factor_auth_enabled) {
            $rules = array_merge($rules, [
                    'phone_country_code' => 'required',
                    'phone_number' => 'required|unique:users,phone_number,' . user()->id,
                ]
            );
        }


        return $rules;
    }
}
