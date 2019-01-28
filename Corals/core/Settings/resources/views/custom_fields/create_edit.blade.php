@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('custom_field_settings_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($customFieldSetting) !!}

                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('name','Settings::attributes.custom_field.name',true) !!}
                        {!! CoralsForm::select('type', 'Settings::attributes.custom_field.type', get_array_key_translation(config('settings.models.custom_field_setting.supported_types')), true,$customFieldSetting->type,$customFieldSetting->exists?['readonly']:[]) !!}
                        {!! CoralsForm::select('model','Settings::attributes.custom_field.model', \Settings::getCustomFieldsModels(), true, null, $customFieldSetting->exists?['readonly']:[], $customFieldSetting->exists?'select':'select2') !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::checkbox('required', 'Settings::attributes.custom_field.required', $customFieldSetting->required) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::text('label','Settings::attributes.custom_field.label',false) !!}
                        {!! CoralsForm::text('default_value','Settings::attributes.custom_field.default_value',false) !!}
                        {!! CoralsForm::text('validation_rules','Settings::attributes.custom_field.validation_rules',false) !!}

                        {!! CoralsForm::label('custom_attributes', 'Settings::attributes.custom_field.attribute') !!}
                        @include('components.key_value',[
                        'label'=>['key'=> trans('Corals::labels.key'), 'value'=>trans('Corals::labels.value')],
                        'name'=>'custom_attributes',
                        'options'=>$customFieldSetting->custom_attributes??[]
                        ])
                    </div>
                    <div class="col-md-4">

                        <div style="display: none;" id="options-field">
                            {!! CoralsForm::select('options_options[source]', 'Settings::attributes.custom_field.options_source', ['static'=>'Static','database'=>'Database'], true,$customFieldSetting->options_options['source'],$customFieldSetting->exists?['readonly']:[]) !!}
                            <div class="form-group options-source options-source-database" style="display: none;">
                                {!! CoralsForm::select('options_options[source_model]','Settings::attributes.custom_field.options_source_model', \Settings::getCustomFieldsModels(), true, null, $customFieldSetting->exists?['readonly']:[], $customFieldSetting->exists?'select':'select2') !!}
                                {!! CoralsForm::text('options_options[source_model_column]','Settings::attributes.custom_field.options_source_model_column',true,null, $customFieldSetting->exists?['readonly']:[]) !!}

                            </div>
                            <div class="form-group options-source options-source-static" style="display: none;">
                                <span data-name="options"></span>
                                {!! CoralsForm::label('options', 'Settings::attributes.custom_field.options') !!}
                                @include('components.key_value',[
                                'label'=>['key' => trans('Corals::labels.key'), 'value' => trans('Corals::labels.value')],
                                'name'=>'options',
                                'options'=> $customFieldSetting->options??[]
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($customFieldSetting) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var $type = $("#type");
            var $options_source = $("select[name='options_options[source]']");
            var optins_types = ['select', 'radio', 'multi_values'];
            if (_.includes(optins_types, $type.val())) {
                $("#options-field").fadeIn();
            }

            if ($options_source.val()) {
                $(".options-source").fadeOut();
                $(".options-source-" + $options_source.val()).fadeIn();

            }
            $type.change(function (event) {
                if (_.includes(optins_types, $(this).val())) {
                    $("#options-field").fadeIn();
                } else {
                    $("#options-field").fadeOut();
                }
            })
            $options_source.change(function (event) {
                $(".options-source").fadeOut();
                $(".options-source-" + $options_source.val()).fadeIn();
            })

        });
    </script>
@endsection