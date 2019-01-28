<?php

namespace Corals\Modules\Ecommerce\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Ecommerce\Models\Product;
use Corals\Modules\Ecommerce\Traits\DownloadableRequest;
use Validator;

class ProductRequest extends BaseRequest
{
    use DownloadableRequest;

    public function __construct()
    {

        Validator::extend("unique_with_global", function ($attribute, $value, $parameters) {

            $global_options = $this->get('global_options', []);
            return (!array_intersect($value, $global_options));

        });
    }

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
                'caption' => 'required',
                'status' => 'required',
                'type' => 'required',
                'inventory' => 'required_if:type,simple',
                'regular_price' => 'required_if:type,simple',
                'code' => 'required_if:type,simple',
                'variation_options' => 'required_if:type,variable|unique_with_global',
                'categories' => 'required',
                'shipping.width' => 'required_with_all:shipping.enabled,code',
                'shipping.height' => 'required_with_all:shipping.enabled,code',
                'shipping.length' => 'required_with_all:shipping.enabled,code',
                'shipping.weight' => 'required_with_all:shipping.enabled,code',
            ]);

            if ($this->input('type') == 'simple' && in_array($this->input('type'), ['finite', 'bucket'])) {
                $rules['inventory_value'] = 'required';
            }
        }

        if ($this->isStore()) {

            $rules = $this->downloadableStoreRules($rules);
            $rules = array_merge($rules, [
                'slug' => 'max:191|unique:ecommerce_products,slug'
            ]);
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $product = $this->route('product');

            $rules = $this->downloadableUpdateRules($rules, $product);

            $rules = array_merge($rules, [
                'slug' => 'max:191|unique:ecommerce_products,slug,' . $product->id,
            ]);
            $rules = array_merge($rules, []);
        }



        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'shipping.enabled' => 'shipping enabled',
            'shipping.width' => 'width',
            'shipping.height' => 'height',
            'shipping.length' => 'length',
            'shipping.weight' => 'weight',
            'code' => 'SKU code'
        ];

        $attributes = $this->downloadableAttributes($attributes);

        return $attributes;
    }

    public function messages()
    {
        $messages['unique_with_global'] = trans('Ecommerce::labels.product.option_cannot_global');
        return $this->downloadableMessages($messages);
    }
}
