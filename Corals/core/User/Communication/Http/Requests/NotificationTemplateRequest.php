<?php

namespace Corals\User\Communication\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\User\Communication\Models\NotificationTemplate;

class NotificationTemplateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->model = $this->route('notification_template');

        $this->model = is_null($this->model) ? NotificationTemplate::class : $this->model;

        if ($this->isCreate() or $this->isStore() or $this->isDelete()) {
            return false;
        } else {
            return $this->isAuthorized();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $notification_template = $this->route('notification_template');

            $rules = array_merge($rules, [
                'title' => 'required',
                'via' => 'required',
                'body.*' => 'required'
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'body.*' => trans('Notification::validation.messages.notification_template.body'),
        ];
    }

}
