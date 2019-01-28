<?php

namespace Corals\Modules\Announcement\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Announcement\Models\Announcement;

class AnnouncementRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Announcement::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Announcement::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'title' => 'required|max:191',
                'starts_at' => 'required|date',
                'ends_at' => 'required|date|after_or_equal:starts_at',
                'content' => '',
                'image' => 'image|max:' . maxUploadFileSize(),
                'link' => 'max:255'
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $announcement = $this->route('announcement');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
