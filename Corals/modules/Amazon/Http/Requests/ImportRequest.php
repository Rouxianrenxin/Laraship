<?php

namespace Corals\Modules\Amazon\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Amazon\Models\Import;

class ImportRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Import::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Import::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required|max:191',
                'keywords' => 'required',
                'max_result_pages' => 'required',
                'image_count' => 'required',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'title' => 'required|max:191|unique:amazon_imports,title'
            ]);
        }

        if ($this->isUpdate()) {
            $import = $this->route('import');

            $rules = array_merge($rules, [
                'title' => 'required|max:191|unique:amazon_imports,title,' . $import->id,
            ]);
        }

        return $rules;
    }
}
