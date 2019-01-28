<?php

namespace Corals\Modules\Newsletter\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Newsletter\Models\Subscriber;

class SubscriberRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Subscriber::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Subscriber::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'max:191'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'email' => 'required|email|max:191|unique:newsletter_subscribers,email',
            ]);
        }

        if ($this->isUpdate()) {
            $subscriber = $this->route('subscriber');

            $rules = array_merge($rules, [
                'email' => 'required|email|max:191|unique:newsletter_subscribers,email,' . $subscriber->id,
            ]);
        }

        return $rules;
    }
}
