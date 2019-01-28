<?php

namespace Corals\Foundation\Classes;

use Collective\Html\FormFacade as Form;
use Collective\Html\HtmlFacade as Html;
use Corals\Foundation\Traits\Language\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class CoralsForm
{
    const CONTROLS_CLASS = 'form-control ';
    const INPUT_GROUP_CLASS = 'input-group ';
    const INPUT_GROUP_ADDON_CLASS = 'input-group-addon ';
    const INPUT_GROUP_ADDON_LEFT_CLASS = 'input-group-prepend';
    const INPUT_GROUP_ADDON_RIGHT_CLASS = 'input-group-append';
    const ERROR_SPAN_CLASS = 'help-block form-control-feedback';
    const HELP_TEXT_CLASS = 'text-muted text-sm';
    const REQUIRED_FIELD_CLASS = 'required-field ';
    const FORM_GROUP_CLASS = 'form-group ';
    const FORM_GROUP_ERROR_CLASS = 'has-danger ';
    const SELECT2_CLASS = 'select2-normal ';
    const FILE_CLASS = '';
    const SPACER = '&nbsp;&nbsp;';

    protected $skipValueTypes = ['file', 'password'];
    protected $isCheckboxRadio = ['checkbox', 'radio'];
    protected $selectTypes = ['boolean', 'select', 'select2'];

    public function __construct()
    {
    }

    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }

    public function label($key, $label, $attributes = [])
    {
        return $this->inputLabel($key, $label, $attributes);
    }

    public function inputLabel($key, $label, $attributes = [])
    {
        if (empty($label)) {
            return '';
        }
        return Form::label($key, trans($label), $attributes);
    }

    public function helpText($text)
    {
        return '<div class="' . self::HELP_TEXT_CLASS . '">' . trans($text) . '</div>';
    }

    public function inputAddon($addon, $left = true)
    {
        if (empty($addon)) {
            return '';
        } else {
            $class = $left ? self::INPUT_GROUP_ADDON_LEFT_CLASS : self::INPUT_GROUP_ADDON_RIGHT_CLASS;
            return '<div class="' . self::INPUT_GROUP_ADDON_CLASS . ' ' . $class . '"><div class="input-group-text">' . $addon . '</div></div>';
        }
    }

    public function errorMessage($key)
    {
        $error = '';

        $errors = view()->shared('errors');

        if (!is_null($errors) && count($errors) > 0 && $errors->has($key)) {
            $error = '<span class="' . self::ERROR_SPAN_CLASS . '">' . $errors->first($key) . '</span>';
        }

        return $error;
    }

    public function formGroup($content, $required = false, $error = null, $class = '')
    {
        if (empty($class)) {
            $class = self::FORM_GROUP_CLASS;
        }
        if ($required) {
            $class .= self::REQUIRED_FIELD_CLASS;
        }

        if (!empty($error)) {
            $class .= self::FORM_GROUP_ERROR_CLASS;
            $content = $content . $error;
        }

        return '<div class="' . $class . '">' . $content . '</div>';
    }

    public function input($key, $label = '', $required = false, $value = null, $attributes = [], $type)
    {
        $attributes['class'] = self::CONTROLS_CLASS . array_get($attributes, 'class', '');

        $wrapper_class = self::FORM_GROUP_CLASS . ' ' . array_pull($attributes, 'wrapper_class') . ' ';


        $attributes['placeholder'] = trans(array_get($attributes, 'placeholder', $label ?? ''));

        $attributes['id'] = array_get($attributes, 'id', $key);

        $attributes = $this->setDataAttribute($attributes);

        $labelAttributes = array_pull($attributes, 'label', []);

        $help_text = array_pull($attributes, 'help_text', '');

        if (!empty($help_text)) {
            $help_text = $this->helpText($help_text);
        }

        $left_addon = array_pull($attributes, 'left_addon', '');
        $right_addon = array_pull($attributes, 'right_addon', '');

        if (!empty($left_addon) || !empty($right_addon)) {
            $left_addon = $this->inputAddon($left_addon, true);
            $right_addon = $this->inputAddon($right_addon, false);
        }

        //remove empty empty attributes
        $attributes = array_filter($attributes, 'removeEmptyArrayElement');

        // in case selectTypes, radio, checkboxes
        $options = array_pull($attributes, 'options', []);

        if (in_array($type, $this->selectTypes)) {
            $input = Form::select($key, $options, $value, array_merge([], $attributes));
        } elseif (in_array($type, $this->skipValueTypes)) {
            $input = Form::{$type}($key, array_merge([], $attributes));

            if ($type == 'file') {
                $image = array_get($attributes, 'with_preview', true) ? '<br/><br/><img  src="#" alt="" class="preview hidden" width="100"/>' : '';
                $input = '<div class="upload-file-area" data-input="' . $attributes['id'] . '"><span class="' . self::FILE_CLASS . '">' . trans('Corals::labels.browse') . $input . '</span>' . self::SPACER . '<span class="file-name"></span>' . $image . '</div>';
            }
        } elseif ($type == 'checkbox') {
            $attributes['class'] = array_get($attributes, 'class', '') . ' custom-control-input';
            $checked = array_pull($attributes, 'checked', false);
            $id = array_get($attributes, 'id', $key);

            $input = '<div class="custom-control custom-checkbox">';
            $input .= Form::{$type}($key, $value, $checked, array_merge([], $attributes));
            $input .= '<label class="custom-control-label" for="' . $id . '">' . self::SPACER . trans($label) . '</label></div>';
            $label = '';
        } elseif ($type == 'checkboxes') {
            $attributes['class'] = array_get($attributes, 'class', '') . ' custom-control-input';
            $selected = $value;
            //$checkboxesWrapper to add ability to checkboxes to be inline with label you can use span for this case
            $checkboxesWrapper = array_pull($attributes, 'checkboxes_wrapper', 'div');

            $input = "<$checkboxesWrapper>";

            foreach ($options as $checkbox_value => $checkbox_label) {
                $attributes['id'] = $checkbox_value . '_' . str_random(6);
                $input .= '<span class="custom-control custom-checkbox">';
                $input .= Form::checkbox($key, $checkbox_value, in_array($checkbox_value, $selected), array_merge([], $attributes));
                $input .= '<label class="custom-control-label" for="' . $attributes['id'] . '">' . self::SPACER . $checkbox_label . '</label></span>' . self::SPACER;
            }

            $input = $input . "</$checkboxesWrapper>";
        } elseif ($type == 'radio') {
            $attributes['class'] = array_get($attributes, 'class', '') . ' custom-control-input';
            $selected = $value;
            $input = '<div style="padding: 3px 0;">';
            foreach ($options as $radio_value => $radio_label) {
                $attributes['id'] = $radio_value . '_' . str_random(6);
                $input .= '<span class="custom-control custom-radio">';
                $input .= Form::radio($key, $radio_value, $radio_value == $selected, array_merge([], $attributes));
                $input .= '<label class="custom-control-label" for="' . $attributes['id'] . '">' . self::SPACER . $radio_label . '</label></span>' . self::SPACER;
            }
            $input = $input . '</div>';
        } elseif ($type == 'date_range') {
            $input = '<div class="input-group input-daterange" data-autoclose="true" data-date-format="yyyy-mm-dd">';
            $input .= $this->date($key . "['from']", '', $required, $value, $attributes);
            $input .= '<div class="input-group-addon">to</div>';
            $input .= $this->date($key . "['to']", '', $required, $value, $attributes);
            $input .= '</div>';

        } else {
            $input = Form::{$type}($key, $value, array_merge([], $attributes));
        }

        $label = $this->inputLabel($key, $label, $labelAttributes);

        if (!empty($left_addon) || !empty($right_addon)) {
            $input = '<div class="' . self::INPUT_GROUP_CLASS . '">' . $left_addon . $input . $right_addon . '</div>';
        }

        $response = $label . $input . $help_text;

        return $this->toHtmlString($this->formGroup($response, $required, $this->errorMessage($key), $wrapper_class));
    }

    public function checkbox($key, $label = '', $checked = false, $value = 1, $attributes = [])
    {
        $attributes['value'] = $value;
        $attributes['checked'] = $checked;

        return $this->input($key, $label, false, $value, $attributes, 'checkbox');
    }

    public function checkboxes($key, $label = '', $required = false, $options, $selected, $attributes = [])
    {
        $options = $this->getArrayOf($options);
        $attributes['options'] = $options;
        return $this->input($key, $label, $required, $selected, $attributes, 'checkboxes');
    }

    public function radio($key, $label = '', $required = false, $options, $selected = null, $attributes = [])
    {
        $options = $this->getArrayOf($options);
        $attributes['options'] = $options;
        return $this->input($key, $label, $required, $selected, $attributes, 'radio');
    }

    public function text($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        return $this->input($key, $label, $required, $value, $attributes, 'text');
    }

    public function date($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        return $this->input($key, $label, $required, $value, $attributes, 'date');
    }

    public function dateRange($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        return $this->input($key, $label, $required, $value, $attributes, 'date_range');
    }

    public function textarea($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        if (array_has($attributes, 'class') && str_contains($attributes['class'], 'ckeditor')) {
            \Assets::add(asset('assets/corals/plugins/ckeditor/ckeditor.js'));
        }

        $attributes['rows'] = array_get($attributes, 'rows', '4');

        return $this->input($key, $label, $required, $value, $attributes, 'textarea');
    }

    public function number($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        return $this->input($key, $label, $required, $value, $attributes, 'number');
    }

    public function email($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        return $this->input($key, $label, $required, $value, $attributes, 'email');
    }

    public function password($key, $label = '', $required = false, $attributes = [])
    {
        return $this->input($key, $label, $required, null, $attributes, 'password');
    }

    public function boolean($key, $label = '', $required = false, $value = null, $attributes = [])
    {
        $options = array_pull($attributes, 'options', ['true' => 'True', 'false' => 'False']);

        return $this->select($key, $label, $options, $required, $value, $attributes, 'boolean');
    }

    public function select($key, $label = '', $options = [], $required = false, $value = null, $attributes = [], $type = 'select')
    {
        if (!empty($label)) {
            $label = trans($label);
        }
        $placeholder = trans('Corals::labels.select', ['label' => $label]);

        if ($type != 'select2') {
            $attributes['placeholder'] = array_get($attributes, 'placeholder', $placeholder);
        } else {
            $attributes['placeholder'] = '';
            $attributes['data-placeholder'] = array_get($attributes, 'data-placeholder', $placeholder);
            $attributes['class'] = array_get($attributes, 'class', 'select2-normal');

            if (!str_contains($attributes['class'], 'select2')) {
                $attributes['class'] .= ' ' . self::SELECT2_CLASS;
            }

            $options = $this->getArrayOf($options);

            if (!array_get($attributes, 'multiple', false)) {
                //add empty option to enable select2 placeholder
                $options = ['' => ''] + $options;
            }
        }

        $attributes['options'] = $options;

        return $this->input($key, $label, $required, $value, $attributes, $type);
    }

    public function file($key, $label = '', $required = false, $attributes = [])
    {
        return $this->input($key, $label, $required, null, $attributes, 'file');
    }

    /**
     * get array from collection object if options passed as object
     * @param $options
     * @return array
     */
    protected function getArrayOf($options)
    {
        if (gettype($options) == 'object') {
            try {
                $options = $options->toArray();
            } catch (\Exception $exception) {
                $options = [];
            }
        }

        return $options;
    }

    /**
     * @param $href
     * @param $label
     * @param array $attributes
     * @return HtmlString
     */
    public function link($href, $label, $attributes = [])
    {
        $attributes = $this->setDataAttribute($attributes);

        $attributes['href'] = $href;

        $html_attributes = Html::attributes($attributes);

        return $this->toHtmlString('<a' . $html_attributes . '>' . trans($label) . '</a>');
    }

    /**
     * @param $attributes
     * @return mixed
     */
    protected function setDataAttribute($attributes)
    {
        $data = array_pull($attributes, 'data', []);

        foreach ($data as $key => $value) {
            $attributes['data-' . $key] = $value;
        }

        return $attributes;
    }

    /**
     * @param $label
     * @param array $attributes
     * @param string $type
     * @return HtmlString
     */
    public function button($label, $attributes = [], $type = 'button')
    {
        $attributes = $this->setDataAttribute($attributes);

        $attributes['type'] = $type;

        $html_attributes = Html::attributes($attributes);

        return $this->toHtmlString('<button' . $html_attributes . '>' . trans($label) . '</button>');
    }

    public function formButtons($label = '', $attributes = [], $cancelAttributes = [], $extraButtons = [])
    {
        $wrapper_class = array_pull($attributes, 'wrapper_class', self::FORM_GROUP_CLASS . ' text-right');


        if (empty($label)) {
            $label = '<i class="fa fa-save"></i> ' . (view()->shared('title_singular') ?: '');
        }

        $buttons = '';

        if (!empty($extraButtons)) {
            foreach ($extraButtons as $extraButton) {
                $buttons .= $this->button($extraButton['label'], $extraButton['attributes'] ?? [], $extraButton['type'] ?? 'button');
            }
        }

        $buttons .= $this->button($label, array_merge(['class' => 'btn btn-success'], $attributes), 'submit');

        if (array_get($cancelAttributes, 'show_cancel', true)) {
            $cancelLabel = array_get($cancelAttributes, 'label', trans('Corals::labels.cancel'));

            $cancelHrefDefault = view()->shared('resource_url') ?: 'dashboard';

            $cancelHref = array_get($cancelAttributes, 'href', $cancelHrefDefault);

            $buttons .= self::SPACER . $this->link(url($cancelHref), $cancelLabel, array_merge(['class' => 'btn btn-warning'], $cancelAttributes));
        }

        return $this->toHtmlString($this->formGroup($buttons, false, null, $wrapper_class));
    }

    public function customFields($model, $fieldClass = 'col-md-4')
    {
        // check if model has CustomFieldsModelTrait
        if (!method_exists($model, 'customFieldSettings')) {
            return '';
        }

        $customFields = $model->customFieldSettings();

        $fields = [];

        foreach ($customFields as $field) {
            $value = $model->exists ? $model->{$field->name} : $field->default_value;

            $fields [] = $this->handleCustomFieldInput($field, $value);
        }

        return renderContentInBSRows($fields, $fieldClass);
    }

    protected function handleCustomFieldInput($field, $value = null)
    {
        $input = '';
        $field = $this->parseSourceOptions($field, $value);
        switch ($field->type) {
            case 'label':
                $input = $this->{$field->type}($field->name, $field->label, $field->custom_attributes);
                break;
            case 'number':
            case 'date':
            case 'text':
            case 'textarea':
                $input = $this->{$field->type}($field->name, $field->label, $field->required, $value, $field->custom_attributes);
                break;
            case 'checkbox':
                $input = $this->{$field->type}($field->name, $field->label, $value, 1, $field->custom_attributes);
                break;
            case 'radio':
                $input = $this->{$field->type}($field->name, $field->label, $field->required, $field->options, $value, $field->custom_attributes);
                break;
            case 'select':
                $input = $this->{$field->type}($field->name, $field->label, $field->options, $field->required, $value, $field->custom_attributes, 'select2');
                break;
            case 'multi_values':
                $name = $field->name;

                if (!str_contains('[]', $name)) {
                    $name .= '[]';
                }
                $attributes = array_merge(['class' => 'select2-normal tags', 'multiple' => true], $field->custom_attributes);

                $input = $this->select($name, $field->label, $field->options, $field->required, $value, $attributes, 'select2');
                break;
        }

        return $input;
    }

    private function parseSourceOptions($field, $value)
    {
        if (isset($field->options_options['source']) && ($field->options_options['source'] == "database")) {
            switch ($field->type) {
                case 'checkbox':
                case 'radio':
                    $model = $field->options_options['source_model'];
                    $field->options = $model::all()->pluck($field->options_options['source_model_column'], 'id')->toArray();
                    break;
                case 'select':
                case 'multi_values':
                    $field->options = [];
                    $custom_attribues = [
                        ['data-model', $field->options_options['source_model']],
                        ['data-columns', json_encode([$field->options_options['source_model_column']])],

                        ['class', 'select2-ajax '],
                    ];

                    if ($value) {
                        $custom_attribues = array_merge($custom_attribues, [['data-selected', json_encode(is_array($value) ? $value : [$value])]]);
                    }
                    $field->custom_attributes = $custom_attribues;
                    break;

            }

        }

        return $field;

    }

    /**
     * @param Model|null $model
     * @param array $attributes
     * @return HtmlString
     */
    public function openForm(Model $model = null, $attributes = [])
    {
        // check form method value
        $formDefaultMethod = !is_null($model) ? ($model->exists ? 'PUT' : 'POST') : null;

        $attributes['method'] = array_get($attributes, 'method', $formDefaultMethod);

        if (empty($attributes['method'])) {
            unset($attributes['method']);
        }

        //check form url value
        $attributes['url'] = trim(array_get($attributes, 'url'), '/');

        if (empty($attributes['url'])
            && !array_has($attributes, 'route')
            && !array_has($attributes, 'action')) {
            $resource_url = view()->shared('resource_url');
            if (!empty($resource_url) && !is_null($model)) {
                $attributes['url'] = trim(url($resource_url . '/' . $model->hashed_id), '/');
            } else {
                unset($attributes['url']);
            }
        }

        // check form class attributes
        $attributes['class'] = array_get($attributes, 'class', 'ajax-form');

        if (!is_null($model)) {
            $formOpenTag = Form::model($model, $attributes);
        } else {
            $formOpenTag = Form::open($attributes);
        }


        $customContent = $this->formTagAppendCustomContent($model);
        return $formOpenTag . $customContent;


    }

    /**
     * @param $model
     * @return string
     */
    protected function formTagAppendCustomContent($model)
    {
        $customContent = '';

        if ($model) {
            $customContent .= $this->handleFormWithTranslatableFields($model);
        }

        return $customContent;
    }

    /**
     * @param $model
     * @return string
     */
    protected function handleFormWithTranslatableFields($model)
    {
        $customContent = '';

        $modelHasTrait = !empty(array_search(Translatable::class, class_uses_recursive($model)));


        if ($model && $model->exists && $modelHasTrait && $model->hasTranslatableFields()
            && count(\Settings::get('supported_languages', [])) > 1) {

            $languages = '';

            foreach (\Language::allowed() as $code => $name) {
                $btnClass = 'btn btn-sm btn-default btn-secondary ' . ($code === \App::getLocale() ? 'current-lang' : '');

                $LangBtn = HtmlElement("button.$btnClass", [
                    'type' => 'button',
                    'data-model' => get_class($model),
                    'data-hashed_id' => $model->hashed_id,
                    'data-lang_code' => $code,
                ], \Language::flag($code));

                $languages .= HtmlElement('li', $LangBtn);
            }

            $switcher = HtmlElement('ul.list-inline', $languages);

            $translation_language_code = Form::hidden('translation_language_code', \App::getLocale(),
                ['class' => 'translation_language_code ignore-dirty-state']);
            $customContent .= $translation_language_code;

            $customContent .= HtmlElement('div.row > div.col-md-12 > div.form_language_switcher text-right', $switcher);
        }

        return $customContent;
    }

    /**
     * @param Model|null $model
     * @return string
     */
    public function closeForm(Model $model = null)
    {
        return Form::close();
    }
}
