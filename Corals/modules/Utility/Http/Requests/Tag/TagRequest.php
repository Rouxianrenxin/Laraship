<?php

namespace Corals\Modules\Utility\Http\Requests\Tag;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Utility\Models\Tag\Tag;

class TagRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Tag::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Tag::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:utility_tags,name',
                'slug' => 'required|max:191|unique:utility_tags,slug'
            ]);
        }

        if ($this->isUpdate()) {
            $tag = $this->route('tag');
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:utility_tags,name,' . $tag->id,
                'slug' => 'required|max:191|unique:utility_tags,slug,' . $tag->id,
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
