@extends('layouts.crud.index')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('activities') }}
        @endslot
    @endcomponent
@endsection

@section('actions')
@endsection