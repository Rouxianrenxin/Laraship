<?php

namespace Corals\Modules\Utility\Classes\Category;

use Corals\Foundation\Facades\CoralsForm;
use Corals\Modules\Utility\Models\Category\Attribute;
use Corals\Modules\Utility\Models\Category\AttributeOption;
use Corals\Modules\Utility\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryManager
{

    public function getCategoriesList($module = null, $parentsOnly = false, $objects = false, $status = null, $except = [], $featured = false, $orderBy = 'name ASC')
    {
        $categories = Category::query();

        if ($module) {
            $categories = $categories->where('module', $module);
        }

        if ($status) {
            $categories = $categories->where('status', $status);
        }

        if (!empty($except)) {
            $categories = $categories->whereNotIn('id', $except);
        }

        if ($featured) {
            $categories = $categories->featured();
        }

        if ($parentsOnly) {
            $categories = $categories->whereNull('parent_id')->orWhere('parent_id', 0);

            if ($objects) {
                $categories = $categories->get();
            } else {
                $categories = $categories->pluck('name', 'id')->toArray();
            }

            return $categories;
        }

        $categories = $categories->orderByRaw($orderBy);

        if ($objects) {
            return $categories->get();
        } else {
            $categories = $categories->get();

            $categoriesResult = [];

            foreach ($categories as $category) {
                $categoriesResult = $this->appendCategory($categoriesResult, $category);
            }

            return $categoriesResult;
        }
    }

    /**
     * @param $categories
     * @param $category
     * @param bool $isAChild
     * @return mixed
     */
    protected function appendCategory($categories, $category, $isAChild = false)
    {
        if ($category->hasChildren()) {
            $categories[$category->name] = [];
            foreach ($category->children as $child) {
                $categories[$category->name] = $this->appendCategory($categories[$category->name], $child, true);
            }
        } elseif ($isAChild || $category->isRoot()) {
            $categories[$category->id] = $category->name;
        }

        return $categories;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAttributesList()
    {
        $attributes = Attribute::all()->pluck('label', 'id');

        return $attributes;
    }

    /**
     * @return array
     */
    public function attributesColumnMapping()
    {
        $attributes = Attribute::query()->where('use_as_filter', true)->get();

        $attributesColumnMapping = [];

        foreach ($attributes as $attribute) {
            switch ($attribute->type) {
                case 'checkbox':
                case 'text':
                case 'date':
                    $attributesColumnMapping[$attribute->id]['column'] = 'string_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = 'like';
                    break;
                case 'textarea':
                    $attributesColumnMapping[$attribute->id]['column'] = 'text_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = 'like';
                    break;
                case 'number':
                case 'select':
                case 'multi_values':
                case 'radio':
                    $attributesColumnMapping[$attribute->id]['column'] = 'number_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = '=';
                    break;
                default:
                    $attributesColumnMapping[$attribute->id]['column'] = 'string_value';
                    $attributesColumnMapping[$attribute->id]['operation'] = '=';
            }
        }

        return $attributesColumnMapping;
    }


    /**
     * @param $field
     * @param $product
     * @param array $attributes
     * @return \Illuminate\Support\HtmlString|string
     */
    public function renderAttribute($field, $product = null, $attributes = [])
    {
        $value = null;

        $asFilter = array_pull($attributes, 'as_filter', false);


        if ($product) {
            $options = $product->options()->where('attribute_id', $field->id)->get();
            if ($options->count() > 1) {
                // in case of multiple type
                $value = AttributeOption::whereIn('id', $options->pluck('number_value')->toArray())
                    ->pluck('id')->toArray();
            } elseif ($option = $options->first()) {
                $value = optional($option)->value;
            }
        }

        $input = '';

        switch ($field->type) {
            case 'number':
            case 'date':
            case 'text':
            case 'textarea':
                $input = CoralsForm::{$field->type}('options[' . $field->id . ']', $field->label, $asFilter ? false : $field->required, $value, $attributes);
                break;
            case 'checkbox':
                $input = CoralsForm::{$field->type}('options[' . $field->id . ']', $field->label, $value, 1, $attributes);
                break;
            case 'radio':
                $input = CoralsForm::{$field->type}('options[' . $field->id . ']', $field->label, $asFilter ? false : $field->required, $field->options->pluck('option_display', 'id')->toArray(), $value, $attributes);
                break;
            case 'select':
                $input = CoralsForm::{$field->type}('options[' . $field->id . ']', $field->label, $field->options->pluck('option_display', 'id')->toArray(), $asFilter ? false : $field->required, $value, $attributes, 'select2');
                break;
            case 'multi_values':
                $attributes = array_merge(['class' => 'select2-normal', 'multiple' => true], $attributes);
                $input = CoralsForm::select('options[' . $field->id . '][]', $field->label, $field->options->pluck('option_display', 'id')->toArray(), $asFilter ? false : $field->required, $value, $attributes, 'select2');
                break;
        }

        return $input;
    }

    public function setModelOptions($request, Model $model)
    {
        $options = [];

        if ($request->has('options')) {
            $model->options()->forceDelete();

            foreach ($request->options as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $value_option) {
                        $options[] = [
                            'attribute_id' => $key,
                            'value' => $value_option,
                        ];
                    }
                } else {
                    $options[] = [
                        'attribute_id' => $key,
                        'value' => $value,
                    ];
                }
            }
            $model->options()->createMany($options);
        }
    }
}