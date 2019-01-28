<?php

namespace Corals\Modules\Advert\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Advert\Models\Website;

class WebsiteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Website::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Website::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'url' => 'required|max:191',
                'status' => 'required',
                'contact' => 'required|max:191',
                'email' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:advert_websites,name'
            ]);
        }

        if ($this->isUpdate()) {
            $website = $this->route('website');

            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:advert_websites,name,' . $website->id,
            ]);
        }

        return $rules;
    }
}
