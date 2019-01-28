@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('slider_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($slider) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! CoralsForm::select('type', 'Slider::attributes.slider.type', ['images'=>'Images','videos'=>'Videos','html'=>'Html'],true) !!}
                        {!! CoralsForm::text('name','Slider::attributes.slider.name',true) !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::text('key','Slider::attributes.slider.key',true) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                    </div>
                    <div class="col-md-6">
                        <small>{!! trans('Slider::labels.slider.powered_by') !!}</small>
                        <h4><img src="https://owlcarousel2.github.io/OwlCarousel2/assets/img/owl-logo.png"
                                 height="20"
                                 alt="Owl Carousel 2 Logo"/>Owl Carousel 2</h4>
                        <blockquote>
                            <p>No matter if you are a beginner or an advanced user, starting with Owl is easy.</p>
                        </blockquote>

                        <div class="help-text text-muted">
                            {!! trans('Slider::labels.slider.for_demo_and_docs') !!}
                            <a href="https://owlcarousel2.github.io/OwlCarousel2/" target="_blank">https://owlcarousel2.github.io/OwlCarousel2/</a>
                        </div>
                    </div>
                </div>
                {!! CoralsForm::customFields($slider) !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            @component('components.box')
                <div class="row">
                    @foreach($options as $option)
                        @if ($loop->first)
                            <div class="col-md-4">
                                @endif
                                @if(in_array($option->type,['array','object','array/boolean','function']))
                                    {!! CoralsForm::textarea('init_options['.$option->key.']['.$option->type.']',
                                    $option->description,true,$slider->exists?null:$option->default,
                                    ['rows'=>3,'help_text'=> 'Type: '.$option->type.'<br/>Default: '.$option->default.'<br/> Option key: '.$option->key]) !!}
                                @elseif(in_array($option->type,['number','boolean']))
                                    {!! CoralsForm::{$option->type}('init_options['.$option->key.']['.$option->type.']',
                                    $option->description,false,$slider->exists?null:$option->default,['help_text'=> 'Type: '.$option->type.'<br/>Default: '.$option->default.'<br/> Option key: '.$option->key]) !!}
                                @else
                                    {!! CoralsForm::text('init_options['.$option->key.']['.$option->type.']',
                                    $option->description,
                                    false,
                                    $slider->exists?null:$option->default,
                                    ['help_text'=> 'Type: '.$option->type.'<br/>Default: '.$option->default.'<br/> Option key: '.$option->key]) !!}
                                @endif
                                @if($loop->last)
                            </div>
                        @elseif ($loop->index % 10 ==0 && !$loop->first )
                </div>
                <div class="col-md-4">
                    @endif
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($slider) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection