<?php

namespace Corals\Modules\Newsletter\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Newsletter\Models\Subscriber;

class SubscriberImportRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Subscriber::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Subscriber::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
        }

        if ($this->isStore()) {
            $rules = [
                'subscribers_file' => 'required|file|mimetypes:application/vnd.ms-office,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            ];
        }

        if ($this->isUpdate()) {

        }

        return $rules;
    }

    public function messages()
    {
        return [
            'subscribers_file.mimetypes' => trans('Newsletter::validation.subscriber_import.subscribers_file.mimetypes'),
        ];
    }

}
