<?php

namespace Corals\Modules\Ecommerce\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Ecommerce\Models\Coupon;

class CouponRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Coupon::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Coupon::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'start' => 'required|date',
                'expiry' => 'required|date|after:start',
                'type' => 'required',
                'value' => 'required'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'code' => 'required|max:191|unique:ecommerce_coupons,code'
            ]);
        }

        if ($this->isUpdate()) {
            $coupon = $this->route('coupon');
            $rules = array_merge($rules, [
                'code' => 'required|max:191|unique:ecommerce_coupons,code,' . $coupon->id,
            ]);
        }

        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $data = $this->all();

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
