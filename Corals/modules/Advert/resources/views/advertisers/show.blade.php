@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('advertiser_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                <p>@lang('Advert::attributes.advertiser.name'):<strong>{{ $advertiser->name }}</strong></p>
                <p>@lang('Advert::attributes.advertiser.contact'):<strong>{{ $advertiser->contact }}</strong></p>
                <p>@lang('Advert::attributes.advertiser.email'):<strong>{{ $advertiser->email }}</strong></p>
                <p>@lang('Corals::attributes.status'):<strong>{!! $advertiser->present('status')  !!}</strong></p>
                <p>@lang('Advert::attributes.advertiser.notes'):<br/>
                    {{ $advertiser->notes??'-' }}</p>
            @endcomponent
        </div>
        <div class="col-md-8">
            @component('components.box',['box_title'=>'Campaigns'])

                <div class="table-responsive" style="padding-bottom: 100px;">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>@lang('Advert::attributes.campaign.name')</th>
                            <th>@lang('Advert::attributes.campaign.starts_at')</th>
                            <th>@lang('Advert::attributes.campaign.ends_at')</th>
                            <th>@lang('Advert::attributes.campaign.limit_type')</th>
                            <th>@lang('Advert::attributes.campaign.limit_per_day')</th>
                            <th>@lang('Advert::attributes.campaign.weight')</th>
                            <th>@lang('Corals::attributes.status')</th>
                            <th>@lang('Advert::attributes.campaign.notes')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($advertiser->campaigns as $campaign)
                            <tr>
                                <td>{!! $campaign->present('name') !!}</td>
                                <td>{!! $campaign->present('starts_at')  !!}</td>
                                <td>{!! $campaign->present('ends_at')  !!}</td>
                                <td>{!! $campaign->present('limit_type')  !!}</td>
                                <td>{!! $campaign->present('limit_per_day')  !!}</td>
                                <td>{!! $campaign->present('weight')  !!}</td>
                                <td>{!! $campaign->present('status')  !!}</td>
                                <td>{!! $campaign->present('notes')  !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
@endsection

