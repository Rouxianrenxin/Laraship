<?php

namespace Corals\Modules\Ecommerce\Traits;


trait DownloadableRequest
{
    public function downloadableAttributes($attributes)
    {
        foreach ($this->get('downloads', []) as $index => $download) {
            $attributes["downloads.$index.file"] = 'file';
            $attributes["downloads.$index.description"] = 'description';
        }

        return $attributes;
    }

    public function downloadableMessages($messages)
    {
        $messages['downloads.required'] = trans('Ecommerce::exception.misc.least_should_upload');

        return $messages;
    }

    public function downloadableUpdateRules($rules, $model)
    {
        if ($this->has('downloads_enabled')) {
            $rules["downloads"] = 'required';
        }

        $clearedMedia = $this->get('cleared_downloads', []);

        if (count($model->downloads) > count($clearedMedia)) {
            unset($rules['downloads']);
        }

        return $rules;
    }

    public function downloadableStoreRules($rules)
    {
        if ($this->has('downloads_enabled')) {
            $rules["downloads"] = 'required';
            foreach ($this->get('downloads', []) as $index => $download) {
                $rules["downloads.$index.file"] = 'required|mimes:jpg,jpeg,png,zip,rar,txt,pdf,docs,xls,xlsx,doc|max:' . maxUploadFileSize();
                $rules["downloads.$index.description"] = 'required';
            }
        }

        return $rules;
    }
}