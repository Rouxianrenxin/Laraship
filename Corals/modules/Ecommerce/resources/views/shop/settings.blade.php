@extends('layouts.master')

@section('title', $title_singular)

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_settings') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        @if(count($settings))
            <div class="col-md-10">
                @component('components.box',['box_class'=>'box-success'])
                    <ul class="nav nav-tabs">
                        @foreach($settings as $setting_key => $setting)
                            <li class="nav-item {{ $loop->first ? 'active':'' }}">
                                <a data-toggle="tab" href="#{{ $setting_key }}"
                                   class="{{ $loop->first ? 'active':'' }} nav-link">{{  $setting_key }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">

                        @foreach($settings as $setting_key => $setting_items)
                            <div id="{{ $setting_key }}"
                                 class="tab-pane {{ $loop->first ? 'active':'' }} ">
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! CoralsForm::openForm() !!}
                                        @foreach($setting_items as $key => $setting)
                                            @php $setting_field = 'ecommerce_'.strtolower($setting_key).'_'.$key @endphp

                                            @if($setting['type'] == 'text')
                                                {!! CoralsForm::text($setting_field,$setting['label'],$setting['required'],\Settings::get($setting_field)) !!}
                                            @elseif($setting['type'] == 'number')
                                                {!! CoralsForm::number($setting_field,$setting['label'],$setting['required'],\Settings::get($setting_field),['step'=>array_get($setting, 'step', 1)]) !!}
                                            @elseif($setting['type'] == 'boolean')
                                                {!! CoralsForm::boolean($setting_field,$setting['label'],false, \Settings::get($setting_field, 'false')) !!}
                                            @elseif($setting['type']=='select')
                                                {!! CoralsForm::select($setting_field,$setting['label'],$setting['options'], $setting['required'], \Settings::get($setting_field)) !!}
                                            @endif
                                        @endforeach
                                        {!! CoralsForm::formButtons('<i class="fa fa-save"></i> Save '.$setting_key.' Settings',[],['href'=>url('dashboard')]) !!}

                                        {!! CoralsForm::closeForm() !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endcomponent
            </div>
        @else
            <div class="col-md-4">
                <div class="alert alert-warning">
                    <h4>@lang('Ecommerce::labels.shop.no_setting_found')</h4>
                </div>
            </div>
        @endif
    </div>
@endsection