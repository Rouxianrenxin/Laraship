<?php

namespace Corals\Modules\Advert\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Advert\Models\Advertiser;

class AdvertiserRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Advertiser::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Advertiser::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'contact' => 'required|max:191',
                'email' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:advert_advertisers,name'
            ]);
        }

        if ($this->isUpdate()) {
            $advertiser = $this->route('advertiser');

            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:advert_advertisers,name,' . $advertiser->id,
            ]);
        }

        return $rules;
    }
}
