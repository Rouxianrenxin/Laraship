<?php

namespace Corals\Modules\Foo\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Foo\Models\Bar;

class BarRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Bar::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Bar::class);
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
            $bar = $this->route('bar');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
