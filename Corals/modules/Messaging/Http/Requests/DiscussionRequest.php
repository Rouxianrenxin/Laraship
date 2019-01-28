<?php

namespace Corals\Modules\Messaging\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Messaging\Models\Discussion;

class DiscussionRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Discussion::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Discussion::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'user_id' => 'required',
                'subject' => 'required|max:191',
                'body' => 'required',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $discussion = $this->route('discussion');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
