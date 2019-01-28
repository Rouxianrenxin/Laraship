@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('slide_create_edit',$slider) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($slide, ['files' => true]) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! CoralsForm::text('name','Slider::attributes.slide.name',true) !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($slider->type == 'html')
                            {!! CoralsForm::textarea('content','Slider::attributes.slide.content',true, null, ['class'=>'ckeditor']) !!}
                        @elseif($slider->type == 'images')
                            <div class="row">
                                <div class="col-md-6">
                                    @if($slide->content)
                                        <img src="{{ $slide->content }}" class="img-responsive" style="max-width: 100%;"
                                             alt="Slide Image"/>
                                        <br/>
                                    @endif
                                    {!! CoralsForm::file('content', 'Slider::labels.slide.content_image') !!}
                                    <h4 class="text-center">{!! trans('Corals::labels.or') !!}</h4>
                                    {!! CoralsForm::text('link','Slider::attributes.slide.link',false,$slide->content) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! CoralsForm::textarea('description','Slider::attributes.slide.description', false, null, ['class'=>'']) !!}
                                </div>
                            </div>
                        @elseif($slider->type == 'videos')
                            <div class="row">
                                <div class="col-md-6">
                                    {!! CoralsForm::file('content', 'Slider::attributes.slide.content_video') !!}
                                    <h4 class="text-center">{!! trans('Corals::labels.or') !!}</h4>
                                    {!! CoralsForm::text('link','Slider::attributes.slide.link',false,$slide->content) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! CoralsForm::textarea('description','Slider::attributes.slide.description', false, null, ['class'=>'']) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {!! CoralsForm::customFields($slide) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($slide) !!}
            @endcomponent
        </div>
    </div>
@endsection
