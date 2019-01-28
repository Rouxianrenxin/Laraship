<?php

namespace Corals\Modules\Ecommerce\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Ecommerce\Models\SKU;
use Corals\Modules\Ecommerce\Traits\DownloadableRequest;

class SKURequest extends BaseRequest
{
    use DownloadableRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(SKU::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(SKU::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'regular_price' => 'required',
                'status' => 'required',
                'image' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),
                'inventory' => 'required',
                'inventory_value' => 'required_if:inventory,finite,bucket',
            ]);

            $product = request()->route('product');

            foreach ($product->variation_options ?? [] as $option) {
                if ($option->required) {
                    $rules = array_merge($rules, [
                        "options." . $option->id => 'required',
                    ]);
                }
            }
            if ($product->shipping['enabled']) {
                $rules = array_merge($rules, [
                    "shipping.height" => 'required', "shipping.weight" => 'required', "shipping.width" => 'required', "shipping.length" => 'required',
                ]);
            }
        }

        if ($this->isStore()) {

            $rules = $this->downloadableStoreRules($rules);

            $rules = array_merge($rules, [
                'code' => 'required|unique:ecommerce_sku,code'
            ]);
        }

        if ($this->isUpdate()) {
            $sku = $this->route('sku');

            $rules = $this->downloadableUpdateRules($rules, $sku);

            $rules = array_merge($rules, [
                'code' => 'required|unique:ecommerce_sku,code,' . $sku->id
            ]);
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [];
        $product = request()->route('product');

        foreach ($product->variation_options ?? [] as $option) {
            $attributes = array_merge($attributes, [
                "options.$option->id" => $option->label,
            ]);
        }

        $attributes = $this->downloadableAttributes($attributes);

        return $attributes;
    }

    public function messages()
    {
        return $this->downloadableMessages([]);
    }
}
