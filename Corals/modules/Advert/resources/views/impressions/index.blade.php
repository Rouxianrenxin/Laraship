@extends('layouts.crud.index')

@section('css')
    <style>
        table.visitor-details td {
            padding: 5px;
            border: 1px #0b0b0b dashed;
        }
    </style>
@endsection
@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('impressions') }}
        @endslot
    @endcomponent
@endsection