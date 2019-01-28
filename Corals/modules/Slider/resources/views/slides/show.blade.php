@extends('layouts.crud.show')

@section('css')
    <style type="text/css">
        .slide-content img, .item-video {
            max-width: 100%;
        }
    </style>
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('slide_show', $slider) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.box',['box_class'=>'box-success'])
                <h3>{{ $slide->name }}</h3>
                <hr/>
                <div class="slide-content">
                    @if($slide->slider->type == 'html')
                        <div class="item">{!! $slide->content !!}</div>
                    @endif

                    @if($slide->slider->type == 'images')
                        <img src="{!! asset($slide->content) !!}" alt="slide image">
                    @endif

                    @if($slide->slider->type == 'videos')
                        <div class="item-video"><a class="owl-video" href="{!! asset($slide->content) !!}"></a></div>
                    @endif

                    @if($slide->description)
                        <div class="">
                            {!! $slide->description !!}
                        </div>
                    @endif
                </div>
            @endcomponent
        </div>
    </div>
@endsection
