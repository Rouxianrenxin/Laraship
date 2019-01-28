@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('licence_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                <p>@lang('LicenceManager::attributes.licence.code'): <b>{{ $licence->code }}</b></p>
                <p>@lang('LicenceManager::attributes.licence.product'):
                    <b>{!! $licence->presenter()['licenceable'] !!}</b>
                </p>
                <p>@lang('LicenceManager::attributes.licence.order'):
                    <b>{!! $licence->presenter()['parent'] !!}</b>
                </p>
                <p>@lang('Corals::attributes.status'):
                    <b>{{ $licence->presenter()['status'] }}</b>
                </p>
                <p>@lang('LicenceManager::attributes.licence.expiry_period')
                    : {{ $licence->presenter()['expiry_period'] }}</p>
                <p>@lang('LicenceManager::attributes.licence.expiration_date')
                    : {{ $licence->presenter()['expiration_date'] }}</p>
            @endcomponent
        </div>
    </div>
@endsection

