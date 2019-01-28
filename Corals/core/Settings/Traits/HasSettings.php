<?php

namespace Corals\Settings\Traits;

use Corals\Settings\Models\ModelSetting;

trait HasSettings
{
    /**
     * Returns a morphMany relationship.
     *
     * @return morphMany The relationship.
     */
    public function settings()
    {
        return $this->morphMany(ModelSetting::class, 'model');
    }

    /**
     * Returns a Setting model instance.
     *
     * @param string $code Setting code.
     * @return ModelSetting The Setting model.
     */
    public function getSetting(string $code)
    {
        return $this->settings()->where('code', $code)->first();
    }

    /**
     * Get the value of a setting by code and cast type. If no cast type is provided,
     * it will return using the cast stored in the database.
     *
     * @param string $code Setting code.
     * @param string $castType The cast type of the value returned.
     * @return null|string|int|bool|float The value of the setting. Null if does not exist.
     */
    public function getSettingValue(string $code, $castType = null)
    {
        $setting = $this->getSetting($code);
        $value = optional($setting)->value;

        if (is_null($value)) {
            return null;
        }

        switch (($castType) ?: $setting->cast_type) {
            case 'string':
                return (string)$value;
                break;

            case 'integer':
                return (int)$value;
                break;

            case 'boolean':
                return (bool)((string)$value === '1' || (string)$value === 'true');
                break;

            case 'float':
                return (float)$value;
                break;
            case 'array':
                return json_decode($value, true);
                break;
            default:
                return (string)$value;
                break;
        }
    }

    /**
     * Set up a new setting. If the code exists, it updated it.
     *
     * @param string $code Setting code.
     * @param null|string|int|bool|float $value The setting value.
     * @param string $castType The cast type of the value.
     * @return ModelSetting The Setting model.
     */
    public function newSetting(string $code, $value = null, $castType = 'string')
    {
        $castType = $this->validateCastType($castType);

        if ($setting = $this->getSetting($code)) {
            return $this->updateSetting($code, $value, $castType);
        }


        return $this->settings()->save(new ModelSetting([
            'code' => $code,
            'value' => $value,
            'cast_type' => (!is_null($castType)) ? $castType : 'string',
        ]));
    }

    /**
     * Update a setting. If the code does not exist, it is added.
     *
     * @param string $code Setting code.
     * @param null|string|int|bool|float $newValue The setting value.
     * @param string $castType The cast type of the value.
     * @return ModelSetting The Setting model.
     */
    public function updateSetting(string $code, $newValue = null, $castType = null)
    {
        if (!$setting = $this->getSetting($code)) {
            return $this->newSetting($code, $newValue, $castType);
        }

        $castType = $this->validateCastType($castType);

        $setting->update([
            'value' => $newValue,
            'cast_type' => (!is_null($castType)) ? $castType : $setting->cast_type,
        ]);

        return $setting;
    }

    /**
     * Delete a setting. If does not exist, returns null.
     *
     * @param string $code The setting code.
     * @return bool Wether the setting was deleted or not.
     * @throws \Exception
     */
    public function deleteSetting(string $code): bool
    {
        if (!$setting = $this->getSetting($code)) {
            return false;
        }

        return (bool)$setting->delete();
    }

    /**
     * Delete all the settings.
     *
     * @return bool Wether the setting was deleted or not.
     */
    public function deleteSettings()
    {
        return (bool)$this->settings()->delete();
    }

    /**
     * Check if castType is a valid option, if not return string.
     *
     * @param null $castType
     * @return null|string
     */
    private function validateCastType($castType = null)
    {
        if (!is_null($castType) && !in_array($castType,
                ['integer', 'boolean', 'string', 'float', 'array'])) {
            return 'string';
        }

        return $castType;
    }
}
