<?php

namespace Corals\Modules\Referral\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Referral\Models\ReferralLink;

class ReferralLinkRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(ReferralLink::class, 'referral_link');

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(ReferralLink::class, 'referral_link');
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [

            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $referral_link = $this->route('referral_link');

            $rules = array_merge($rules, []);
        }

        return $rules;
    }
}
