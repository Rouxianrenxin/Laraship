@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('banner_show', $campaign??null) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @component('components.box')
        <div class="row">
            <div class="col-md-4">
                <p>@lang('Advert::attributes.banner.name'):<b>{{ $banner->name }}</b></p>
                <p>@lang('Corals::attributes.status'):<b>{!! $banner->present('status') !!}</b></p>
                <p>@lang('Advert::attributes.banner.campaign'):<b>{!! $banner->present('campaign') !!}</b></p>
                <p>@lang('Advert::attributes.banner.dimension'):<b>{!! $banner->present('dimension') !!}</b></p>
                <p>@lang('Advert::attributes.banner.weight'):<b>{!! $banner->present('weight') !!}</b></p>
                <p>@lang('Advert::attributes.banner.type'):<b>{!! $banner->present('type') !!}</b></p>
                <p>@lang('Advert::attributes.banner.url'):<b>{!! $banner->present('url') !!}</b></p>
            </div>
            <div class="col-md-4">
                <p>@lang('Advert::attributes.banner.notes')
                    <br/>{!! $banner->notes??'-' !!}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div style="padding:0; width: {{ $banner->width }}px;height: {{ $banner->height }}px; background-color: #f7f7f7;display: inline-block;">
                    @include('Advert::zones.partials.' . $banner->type,compact('banner'))
                </div>
            </div>
        </div>
    @endcomponent
@endsection

