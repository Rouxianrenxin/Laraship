<?php

namespace Corals\Modules\Directory\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Directory\Models\Claim;

class ClaimRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Claim::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Claim::class);
        $rules = parent::rules();

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'brief_desctiption' => 'required|max:191',
                'claim_file' => 'required|mimes:jpeg,jpg,png,doc,docx,pdf',
            ]);
        }

        return $rules;
    }

}
