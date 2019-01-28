@extends('layouts.crud.index')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('referral_relationships', $referral_program??null) }}
        @endslot
    @endcomponent
@endsection

@section('actions')
@endsection