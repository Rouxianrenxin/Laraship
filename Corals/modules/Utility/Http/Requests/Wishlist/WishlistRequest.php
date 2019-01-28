<?php

namespace Corals\Modules\Utility\Http\Requests\Wishlist;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Utility\Models\Wishlist\Wishlist;

class WishlistRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Wishlist::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Wishlist::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, []);
        }


        return $rules;
    }
}
