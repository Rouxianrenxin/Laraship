@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('website_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                <p>@lang('Advert::attributes.website.name'):<strong>{{ $website->name }}</strong></p>
                <p>@lang('Advert::attributes.website.contact'):<strong>{{ $website->contact }}</strong></p>
                <p>@lang('Advert::attributes.website.email'):<strong>{{ $website->email }}</strong></p>
                <p>@lang('Corals::attributes.status'):<strong>{!! $website->present('status')  !!}</strong></p>
                <p>
                    @lang('Advert::attributes.website.notes'):
                    <br/>
                    {{ $website->notes }}
                </p>
            @endcomponent
        </div>
        <div class="col-md-8">
            @component('components.box',['box_title'=>'Zones'])
                <div class="table-responsive" style="padding-bottom: 100px;">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>@lang('Advert::attributes.zone.name')</th>
                            <th>@lang('Advert::attributes.zone.key')</th>
                            <th>@lang('Advert::attributes.zone.dimension')</th>
                            <th>@lang('Corals::attributes.status')</th>
                            <th>@lang('Advert::attributes.zone.notes')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($website->zones as $zone)
                            <tr>
                                <td>{!! $zone->present('name') !!}</td>
                                <td>{!! $zone->present('key')  !!}</td>
                                <td>{!! $zone->present('dimension')  !!}</td>
                                <td>{!! $zone->present('status')  !!}</td>
                                <td>{!! $zone->present('notes')  !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
@endsection

