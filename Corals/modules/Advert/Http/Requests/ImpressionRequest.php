<?php

namespace Corals\Modules\Advert\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Advert\Models\Impression;

class ImpressionRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Impression::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Impression::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $impression = $this->route('impression');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
