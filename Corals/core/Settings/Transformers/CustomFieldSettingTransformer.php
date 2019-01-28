<?php

namespace Corals\Settings\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Settings\Models\CustomFieldSetting;

class CustomFieldSettingTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('settings.models.custom_field_setting.resource_url');

        parent::__construct();
    }

    /**
     * @param CustomFieldSetting $setting
     * @return array
     * @throws \Throwable
     */
    public function transform(CustomFieldSetting $setting)
    {
        return [
            'id' => $setting->id,
            'name' => $setting->name,
            'model' => class_basename($setting->getAttribute('model')),
            'label' => $setting->label,
            'type' => trans(config('settings.models.custom_field_setting.supported_types')[$setting->type] ?? '-'),
            'created_at' => format_date($setting->created_at),
            'updated_at' => format_date($setting->updated_at),
            'action' => $this->actions($setting)
        ];
    }
}