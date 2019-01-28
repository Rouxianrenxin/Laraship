<?php

namespace Corals\Settings\Traits;


use Corals\Settings\Models\CustomField;
use Corals\Settings\Models\CustomFieldSetting;
use Illuminate\Support\Facades\Cache;

trait CustomFieldsModelTrait
{
    public $customAttributes = [];

    /**
     * get model related custom fields settings
     * @param string $status
     * @return mixed
     */
    public function customFieldSettings($status = 'active')
    {
        if (!schemaHasTable('custom_field_settings')) {
            return collect([]);
        }
        $className = get_class($this);

        $cache_key = str_slug($className) . '_cf_settings';

        $customFieldSettings = Cache::remember($cache_key, 1440, function () use ($className, $status) {
            return CustomFieldSetting::where('model', $className)->where('status', $status)->get();
        });

        return $customFieldSettings;
    }

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function withCustomFields($relations = null)
    {
        $instance = new static;

        if ($relations === null) {
            $relations = $instance->customFieldNames();
        }

        if (is_string($relations)) {
            $relations = func_get_args();
        }

        return $instance->newQuery()->with($relations);
    }

    /**
     * Return custom field relation for specified field name.
     *
     * @param $fieldName
     * @return mixed
     */
    public function customFieldRelation($fieldName)
    {
        return $this->morphOne(CustomField::class, 'parent', 'parent_type')
            ->where('field_name', $fieldName);
    }


    /**
     * Return all custom field names for current model
     *
     * @return array
     */
    public function customFieldNames()
    {
        if (!schemaHasTable('custom_field_settings')) {
            return [];
        }

        $className = get_class($this);

        $cache_key = str_slug($className) . '_cf_name';

        $customFieldSettings = Cache::remember($cache_key, 1440, function () use ($className) {
            return CustomFieldSetting::where('model', $className)->pluck('name')->toArray();
        });

        return $customFieldSettings;
    }


    /**
     * Return true if attribute name belongs to fields.
     *
     * @param $attributeName
     * @return bool
     */
    public function isCustomField($attributeName)
    {
        return in_array($attributeName, $this->customFieldNames());
    }


    /**
     * Dynamically set attributes on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        // set
        if ($this->isCustomField($key)) {
            if ($value instanceof CustomField) {
                $this->$key = $value;
            } else {
                $this->customAttributes[$key] = $value;
            }
        } else {
            parent::__set($key, $value);
        }
    }


    /**
     * Save the model to the database.
     *
     * @param  array $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $parentResult = parent::save($options);

        // save custom fields
        foreach ($this->customFieldNames() as $name) {
            // custom field model instance
            $customFieldModel = $this->getCustomFieldModel($name);

            if ($customFieldModel instanceof CustomField) {
                $customFieldSetting = $customFieldModel->customFieldSetting;

                if (array_has($this->customAttributes, $name)) {
                    $customFieldModel->value = $this->customAttributes[$name];
                    $customFieldModel->save();
                } elseif (in_array($customFieldSetting->type, ['checkbox'])) {
                    $customFieldModel->value = null;
                    $customFieldModel->save();
                }
            }
        }

        \Actions::do_action('post_save', $this);

        return $parentResult;
    }


    /**
     * Fill the model with an array of attributes.
     *
     * @param  array $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $this->fillCustomAttributes($attributes);
        return parent::fill($attributes);
    }


    /**
     * Fill custom fields
     *
     * @param array $attributes
     */
    public function fillCustomAttributes(array &$attributes)
    {
        foreach ($this->customFieldNames() as $name) {
            if (array_has($attributes, $name)) {
                $this->customAttributes[$name] = array_pull($attributes, $name, null);
            }
        }
    }


    /**
     * Delete the model from the database.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        // delete model
        $parentResult = parent::delete();

        // delete custom fields
        if ($parentResult) {
            CustomField::where([
                'parent_type' => get_class($this),
                'parent_id' => $this->id
            ])->delete();
        }

        return $parentResult;
    }


    /**
     * Returns custom field model instance
     *
     * @param $key
     * @return mixed
     */
    public function customFieldModel($key)
    {
        return array_get($this->relations, $key, null);
    }


    /**
     * Create new custom field model instance
     *
     * @param $fieldName
     * @return CustomField
     */
    public function newCustomFieldModel($fieldName)
    {
        return new CustomField([
            'field_name' => $fieldName,
            'parent_type' => get_class($this),
            'parent_id' => $this->id
        ]);
    }


    /**
     * Returns custom field model
     *
     * @param $fieldName
     * @return CustomField
     */
    public function getCustomFieldModel($fieldName)
    {
        $model = $this->getAttribute($fieldName);

        if ($model === null) {
            $model = $this->newCustomFieldModel($fieldName);
            //$this->$fieldName = $model;
        }

        return $model;
    }


    /**
     * Loads custom field model
     *
     * @param $fieldName
     * @return mixed
     */
    public function getAttribute($fieldName)
    {
        $model = parent::getAttribute($fieldName);

        if ($this->isCustomField($fieldName) && $this->exists && schemaHasTable('custom_field_settings')) {
            $model = CustomField::where([
                'parent_type' => get_class($this),
                'parent_id' => $this->id,
                'field_name' => $fieldName
            ])->first();
        }

        return $model;
    }

    public function presentCustomFieldsValues($labelTag = 'span', $valueTag = 'b', $spacer = ': ', $get = ['except' => [], 'only' => []], $colClass = 'col-md-6')
    {
        $fields = [];

        $customFieldNames = $this->customFieldNames();

        if (!empty($get['only'])) {
            $customFieldNames = array_filter($customFieldNames, function ($name) use ($get) {
                return in_array($name, $get['only']);
            });
        }

        if (!empty($get['except'])) {
            $customFieldNames = array_filter($customFieldNames, function ($name) use ($get) {
                return !in_array($name, $get['except']);
            });
        }

        foreach ($customFieldNames as $name) {
            $customFieldModel = $this->getCustomFieldModel($name);

            $customFieldSetting = $customFieldModel->customFieldSetting;

            $fields [] = HtmlElement($labelTag, $customFieldSetting->label) . $spacer
                . HtmlElement($valueTag, $this->{$name});
        }

        return renderContentInBSRows($fields, $colClass);
    }
}
