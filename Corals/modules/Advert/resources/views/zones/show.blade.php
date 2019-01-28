@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('zone_show', $website??null) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                <p>@lang('Advert::attributes.zone.name'):<b>{{ $zone->name }}</b></p>
                <p>@lang('Advert::attributes.zone.website'):<b>{!! $zone->present('website') !!}</b></p>
                <p>@lang('Advert::attributes.zone.key'):{!! $zone->present('key') !!}</p>
                <p>@lang('Advert::attributes.zone.dimension'):<b>{!! $zone->present('dimension') !!}</b></p>
                <p>@lang('Corals::attributes.status'):<b>{!! $zone->present('status') !!}</b></p>
                <p>@lang('Advert::attributes.zone.notes'):<br/>{!! $zone->notes??'-' !!}</p>
                <p>
                   @lang('Advert::attributes.zone.embed_code')
                    {!! \Advert::getZoneEmbedCode($zone) !!}
                </p>
            @endcomponent
        </div>
        <div class="col-md-8">
            @component('components.box',['box_title' => 'Banners'])
                <div class="table-responsive" style="padding-bottom: 100px;">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>@lang('Advert::attributes.banner.name')</th>
                            <th>@lang('Advert::attributes.banner.type')</th>
                            <th>@lang('Advert::attributes.banner.weight')</th>
                            <th>@lang('Corals::attributes.status')</th>
                            <th>@lang('Advert::attributes.banner.notes')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($zone->banners as $banner)
                            <tr>
                                <td>{!! $banner->present('name') !!}</td>
                                <td>{!! $banner->present('type')  !!}</td>
                                <td>{!! $banner->present('weight')  !!}</td>
                                <td>{!! $banner->present('status')  !!}</td>
                                <td>{!! $banner->present('notes')  !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
@endsection

