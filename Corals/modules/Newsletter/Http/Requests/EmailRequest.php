<?php

namespace Corals\Modules\Newsletter\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Newsletter\Models\Email;

class EmailRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Email::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Email::class);

        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'subject' => 'required|max:191',
                'email_body' => 'required',
                'subscribers' => 'required_without_all:mail_lists',
                'mail_lists' => 'required_without_all:subscribers',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $email = $this->route('email');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
