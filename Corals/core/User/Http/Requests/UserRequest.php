<?php

namespace Corals\User\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\User\Models\User;

class UserRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->model = $this->route('user');

        if ($this->isEdit() && !is_null($this->model)) {
            if (!user()->hasPermissionTo('Administrations::admin.user') && $this->model->id != user()->id) {
                return false;
            }
        }

        $this->model = is_null($this->model) ? User::class : $this->model;

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(User::class);
        $rules = parent::rules();
        $is_two_factor_auth_enabled = \Settings::get('two_factor_auth_enabled', false);


        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                    'name' => 'required|max:191',
                    'last_name' => 'required|max:191',
                    'roles' => 'required',
                    'picture' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),
                ]
            );
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                    'email' => 'required|email|max:191|unique:users,email',
                    'password' => 'required|confirmed|max:191|min:6'
                ]
            );
            if ($is_two_factor_auth_enabled) {
                $rules = array_merge($rules, [
                        'phone_country_code' => 'required',
                        'phone_number' => 'required|unique:users',
                    ]
                );
            }

        }

        if ($this->isUpdate()) {
            $user = $this->route('user');

            $rules = array_merge($rules, [
                    'email' => 'required|email|max:191|unique:users,email,' . $user->id,
                    'password' => 'nullable|confirmed|max:191|min:6'
                ]
            );
            if ($is_two_factor_auth_enabled) {
                $rules = array_merge($rules, [
                        'phone_country_code' => 'required',
                        'phone_number' => 'required|unique:users,phone_number,' . $user->id,
                    ]
                );
            }

        }
        return $rules;
    }
}
