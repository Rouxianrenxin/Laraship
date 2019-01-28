<?php

namespace Corals\Modules\Ecommerce\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;

class AddToCartRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        $rules = [];
        $sku = request()->route('sku');

        if (!$sku) {
            $rules = ['sku_hash' => 'required'];
        }

        $product = request()->route('product');

        foreach ($product->global_options ?? [] as $option) {
            if ($option->required) {
                $rules = array_merge($rules, [
                    "options." . $option->id => 'required',
                ]);
            }
        }

        $rules = \Filters::do_filter('add_to_cart_request_rules', $rules, request());

        return $rules;
    }

    public function attributes()
    {
        $attributes = ['sku_hash' => 'SKU'];
        $product = request()->route('product');
        foreach ($product->global_options ?? [] as $option) {
            $attributes = array_merge($attributes, [
                "options.$option->id" => $option->label,
            ]);
        }


        return $attributes;
    }


}
