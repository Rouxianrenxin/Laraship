<?php

namespace Corals\Modules\Payment\Common\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Payment\Models\Tax;

class TaxRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Tax::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Tax::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'priority' => 'required',
                'rate' => 'required',
                'name' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $tax = $this->route('tax');
            $rules = array_merge($rules, []);
        }

        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $data = $this->all();

        $data['compound'] = array_get($data, 'compound', false);

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
