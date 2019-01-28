<?php

namespace Corals\Modules\Messaging\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Messaging\Models\Message;

class MessageRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Message::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Message::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'body' => 'required',
            ]);
        }

        return $rules;
    }
}
