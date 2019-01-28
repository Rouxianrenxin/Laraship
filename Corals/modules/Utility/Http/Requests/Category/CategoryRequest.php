<?php

namespace Corals\Modules\Utility\Http\Requests\Category;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Utility\Models\Category\Category;

class CategoryRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Category::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Category::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'thumbnail' => 'image'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:utility_categories,name',
                'slug' => 'required|max:191|unique:utility_categories,slug'
            ]);
        }

        if ($this->isUpdate()) {
            $category = $this->route('category');
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:utility_categories,name,' . $category->id,
                'slug' => 'required|max:191|unique:utility_categories,slug,' . $category->id,
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

        if (isset($data['slug'])) {
            $data['slug'] = str_slug($data['slug']);
        }

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}