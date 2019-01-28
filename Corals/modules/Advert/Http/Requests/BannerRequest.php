<?php

namespace Corals\Modules\Advert\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Advert\Models\Banner;

class BannerRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Banner::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Banner::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'dimension' => 'required|max:191',
                'weight' => 'required',
                'campaign_id' => 'required',
                'url' => 'max:191',
                'type' => 'required|max:191',
                'script' => 'required_if:type,script',
                'link' => 'required_if:type,link'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'media' => 'required_if:type,image|mimes:jpg,jpeg,png,gif|max:' . maxUploadFileSize(),
                'name' => 'required|max:191|unique:advert_banners,name'
            ]);
        }

        if ($this->isUpdate()) {
            $banner = $this->route('banner');

            $rules = array_merge($rules, [
                'media' => 'mimes:jpg,jpeg,png|max:' . maxUploadFileSize(),
                'name' => 'required|max:191|unique:advert_banners,name,' . $banner->id
            ]);
        }

        return $rules;
    }
}
