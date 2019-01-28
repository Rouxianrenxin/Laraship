<?php

namespace Corals\Settings\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Settings\Models\Setting;

class SettingTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('settings.models.setting.resource_url');

        parent::__construct();
    }

    /**
     * @param Setting $setting
     * @return array
     * @throws \Throwable
     */
    public function transform(Setting $setting)
    {
        $actions = ['delete' => ''];


        if (!$setting->editable) {
            $actions = array_merge($actions, ['edit' => '']);
        }else{
            $actions['edit'] = [
                'icon' => '',
                'href' => url($this->resource_url . '/' . $setting->hashed_id . '/edit'),
                'label' => trans('Corals::labels.edit'),
                'class' => 'modal-load',
                'data' => [
                    'title' => 'Edit'
                ]

            ];
        }

        switch ($setting->type) {
            case "SELECT":
                $setting_value = json_decode($setting->getOriginal('value'));
                $setting_display = formatArrayAsLabels($setting_value, 'info');
                break;
            case "FILE":
                $setting_display = '<a target="_blank" href="' . asset($setting->getFilePath()) . '">' . $setting->getOriginal('value') . '</a>';
                break;
            default:
                $setting_display = str_limit(strip_tags($setting->getOriginal('value')), 50);
                break;
        }


        return [
            'id' => $setting->id,
            'code' => $setting->code,
            'type' => $setting->type,
            'label' => $setting->label,
            'value' => $setting_display,
            'created_at' => format_date($setting->created_at),
            'updated_at' => format_date($setting->updated_at),
            'action' => $this->actions($setting, $actions)
        ];
    }
}