<?php

namespace Corals\Modules\Advert\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Advert\Models\Campaign;

class CampaignRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Campaign::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Campaign::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'advertiser_id' => 'required',
                'starts_at' => 'required|date',
                'ends_at' => 'nullable|date|after_or_equal:starts_at',
                'weight' => 'required',
                'limit_per_day' => 'required_with:limit_type'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:advert_campaigns,name'
            ]);
        }

        if ($this->isUpdate()) {
            $campaign = $this->route('campaign');

            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:advert_campaigns,name,' . $campaign->id,
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

        $data['advertiser_id'] = array_get($data, 'advertiser_id', false);

        $data = \Filters::do_filter('campaign_request_data', $data);


        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();

    }
}