<?php

namespace Corals\Modules\Classified\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Classified\Models\Product;
use Corals\Modules\Utility\Models\Category\Category;

class ProductRequest extends BaseRequest
{
    public $categoryAttributes = [];

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
                'categories' => 'required',
                'price' => 'required_without:price_on_call',
                'price_on_call' => 'required_without:price',
                'location_id' => 'required',
            ]);

            $categories = $this->get('categories', []);

            $categories = Category::query()->whereIn('id', $categories)->get();

            $attributes = collect([]);

            foreach ($categories as $category) {
                $attributes = $attributes->merge($category->categoryAttributes);
            }
            $this->categoryAttributes = $attributes;

            foreach ($attributes as $attribute) {
                if ($attribute->required) {
                    $rules = array_merge($rules, [
                        "options." . $attribute->id => 'required',
                    ]);
                }
            }

        }

        if ($this->isStore()) {

            $rules = array_merge($rules, [
                'slug' => 'max:191|unique:classified_products,slug'
            ]);
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $product = $this->route('product');

            $rules = array_merge($rules, [
                'slug' => 'max:191|unique:classified_products,slug,' . $product->id,
            ]);
            $rules = array_merge($rules, []);
        }


        return $rules;
    }

    public function attributes()
    {
        $attributes = [
        ];

        if ($this->isUpdate() || $this->isStore()) {
            $options = $this->categoryAttributes;

            foreach ($options as $option) {
                $attributes = array_merge($attributes, [
                    "options.$option->id" => $option->label,
                ]);
            }
        }

        return $attributes;
    }

}
