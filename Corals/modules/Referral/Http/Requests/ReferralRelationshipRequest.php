<?php

namespace Corals\Modules\Referral\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Referral\Models\ReferralRelationship;

class ReferralRelationshipRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(ReferralRelationship::class, 'referral_relationship');

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(ReferralRelationship::class, 'referral_relationship');
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [

            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, []);
        }

        if ($this->isUpdate()) {
            $referral_relationship = $this->route('referral_relationship');

            $rules = array_merge($rules, []);
        }

        return $rules;
    }
}
