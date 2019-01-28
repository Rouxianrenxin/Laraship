<?php

namespace Corals\Settings\Classes;

use Corals\Settings\Models\Country;
use Corals\Settings\Models\Setting;

class Settings
{
    protected $custom_fields_models = [];

    /**
     * SettingsHelper constructor.
     */
    function __construct()
    {
    }

    public function getCountriesList()
    {
        return Country::orderBy('name')->pluck('name', 'code')->toArray();
    }

    /**
     * @param $type
     * @param $url
     * @param string $addressDiv
     * @return string
     * @throws \Throwable
     */
    public function getAddressActions($type, $url, $addressDiv = '')
    {
        if (empty($url) || empty($type)) {
            return '';
        }

        $actions = [
            'edit' => [
                'icon' => 'fa fa-fw fa-pencil',
                'href' => url($url . '/' . $type . '/edit'),
                'label' => trans('Settings::labels.settings.edit'),
                'data' => [
                    'action' => 'load',
                    'load_to' => $addressDiv
                ]
            ],
            'delete' => [
                'icon' => 'fa fa-fw fa-remove',
                'href' => url($url . '/' . $type),
                'label' => trans('Settings::labels.settings.delete'),
                'data' => [
                    'action' => 'delete'
                ]
            ],
        ];

        return view('components.item_actions', ['actions' => $actions])->render();
    }

    public function addCustomFieldModel($className, $name = '')
    {
        if (empty($name)) {
            $name = class_basename($className);
        }
        $this->custom_fields_models[$className] = $name;
    }

    public function getCustomFieldsModels()
    {
        return $this->custom_fields_models;
    }

    public function get($key = '', $default = null)
    {
        return $this->getValue($key, $default);
    }

    private function getValue($key, $default)
    {
        if (strpos($key, '*')) {
            $key = str_replace('*', '%', $key);
            $settings = Setting::where('code', 'like', $key);

            $result = [];

            foreach ($settings->get() as $item) {
                $result[$item->code] = $item->value;
            }

            if (empty($result) && !is_null($default)) {
                return $default;
            }

            return $result;
        }

        $setting = Setting::whereCode($key);

        $setting = $setting->first();

        if ($setting) {
            return $setting->value;
        } elseif (!is_null($default)) {
            return $default;
        } else {
            return '';
        }
    }

    /**
     * @param $key
     * @param $value
     * @param string $category
     * @param string $type
     * @param int $editable
     * @param int $hidden
     * @param null $label
     * @return mixed
     */
    public function set($key, $value, $category = 'General', $type = "TEXT", $editable = 0, $hidden = 1, $label = null)
    {
        $setting = Setting::whereCode($key);

        $setting = $setting->first();

        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            if (!$label) {
                $label = $key;
            }

            $setting = Setting::create([
                'code' => $key,
                'type' => $type,
                'category' => $category,
                'value' => $value,
                'editable' => $editable,
                'hidden' => $hidden,
                'label' => $label
            ]);
        }

        return $setting->value;
    }

    public function has($key)
    {
        if (strpos($key, '*')) {
            $key = str_replace('*', '%', $key);
            return (Setting::where('code', 'like', $key)->count() > 0);
        }

        return (Setting::whereCode($key)->count() > 0);
    }

    public function getCategoriesList()
    {
        return Setting::distinct()->get(['category'])->pluck('category', 'category')->toArray();
    }

}