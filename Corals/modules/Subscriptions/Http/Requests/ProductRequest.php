<?php

namespace Corals\Modules\Subscriptions\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Subscriptions\Models\Product;

class ProductRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Product::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Product::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191',
                'status' => 'required',
                'description' => 'required',
                'image' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $product = $this->route('product');
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

        $data['require_shipping_address'] = array_get($data, 'require_shipping_address', false);

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
