<?php

namespace Corals\Modules\Directory\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Utility\Models\Category\Category;
use Corals\Modules\Utility\Models\Category\Attribute;
use Corals\Modules\Directory\Models\Listing;

class ListingRequest extends BaseRequest
{
    public $categoryAttributes = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Listing::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Listing::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191',
                'caption' => 'required',
                'status' => 'required',
                'website' => 'required',
//                'options' => 'required',
                'categories' => 'required',
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
                'slug' => 'max:191|unique:directory_listings,slug'
            ]);
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $listing = $this->route('listing');

            $rules = array_merge($rules, [
                'slug' => 'max:191|unique:directory_listings,slug,' . $listing->id,
            ]);
            $rules = array_merge($rules, []);
        }


        return $rules;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        if ($this->isUpdate() || $this->isStore()) {
            $this->setModel(Listing::class);

            $data = $this->all();
            $user = user();

            if ($this->isStore()) {

                if (user()->cannot('admin', $this->model)) {
                    $data['status'] = \Settings::get('directory_default_listing_status');
                }

            }

            if ($this->isUpdate()) {
                $listing = $this->route('listing');

                if (user()->cannot('admin', $this->model)) {
                    $data['status'] = $listing->status;
                }
            }
            if (user()->can('admin', $this->model)) {
                $data['verified'] = array_get($data, 'verified', false);
                $data['is_featured'] = array_get($data, 'is_featured', false);
            }

            $this->getInputSource()->replace($data);
        }

        return parent::getValidatorInstance();
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
