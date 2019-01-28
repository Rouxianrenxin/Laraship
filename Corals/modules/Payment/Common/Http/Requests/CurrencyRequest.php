<?php


namespace Corals\Modules\Payment\Common\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Payment\Models\Currency;

class CurrencyRequest extends BaseRequest
{


    public function authorize()
    {
        $this->setModel(currency::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Currency::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191',
                'symbol' => 'required|max:25',
                'format' => 'required|max:50',
                'exchange_rate' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'code' => 'required:unique:currencies,code'
            ]);
        }

        if ($this->isUpdate()) {
            $currency = $this->route('currency');

            $rules = array_merge($rules, [
                'code' => 'required:unique:currencies,code,' . $currency->id,
            ]);
        }

        return $rules;
    }

}