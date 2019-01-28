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
            {{ Breadcrumbs::render('campaign_show', $advertiser) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box',['box_class'=>'box-success'])
                <p>@lang('Advert::attributes.campaign.name'):<strong>{{ $campaign->name }}</strong></p>
                <p>@lang('Advert::attributes.campaign.advertiser')
                    :<strong>{!! $campaign->present('advertiser')  !!}</strong></p>
                <p>@lang('Corals::attributes.status'):<strong>{!! $campaign->present('status') !!}</strong></p>
                <p>@lang('Advert::attributes.campaign.starts_at')
                    :<strong>{{ $campaign->present('starts_at') }}</strong></p>
                <p>@lang('Advert::attributes.campaign.ends_at'):<strong>{{ $campaign->present('ends_at') }}</strong>
                </p>
                <p>@lang('Advert::attributes.campaign.weight'):<strong>{{ $campaign->present('weight') }}</strong>
                </p>
                <p>@lang('Advert::attributes.campaign.limit_type')
                    :<strong>{{ $campaign->present('limit_type') }}</strong></p>
                <p>@lang('Advert::attributes.campaign.limit_per_day')
                    :<strong>{{ $campaign->present('limit_per_day') }}</strong></p>
                <p>
                    @lang('Advert::attributes.campaign.notes'):
                    <br/>
                    {{ $advertiser->notes??'-' }}
                </p>
            @endcomponent
        </div>
        <div class="col-md-8">
            @component('components.box',['box_title'=>'Banners'])
                <div class="table-responsive" style="padding-bottom: 100px;">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>@lang('Advert::attributes.banner.name')</th>
                            <th>@lang('Advert::attributes.banner.type')</th>
                            <th>@lang('Advert::attributes.banner.weight')</th>
                            <th>@lang('Advert::attributes.banner.dimension')</th>
                            <th>@lang('Corals::attributes.status')</th>
                            <th>@lang('Advert::attributes.banner.notes')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($campaign->banners as $banner)
                            <tr>
                                <td>{!! $banner->present('name') !!}</td>
                                <td>{!! $banner->present('type')  !!}</td>
                                <td>{!! $banner->present('weight')  !!}</td>
                                <td>{!! $banner->present('dimension')  !!}</td>
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

@section('js')
@endsection