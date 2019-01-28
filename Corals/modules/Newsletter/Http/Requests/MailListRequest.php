<?php

namespace Corals\Modules\Newsletter\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Newsletter\Models\MailList;

class MailListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(MailList::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(MailList::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:newsletter_mail_lists,name',
            ]);
        }

        if ($this->isUpdate()) {
            $mailList = $this->route('mail_list');

            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:newsletter_mail_lists,name,' . $mailList->id,
            ]);
        }

        return $rules;
    }
}
