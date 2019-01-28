@extends('layouts.crud.index')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            Private Pages
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_orders') }}
        @endslot
    @endcomponent
@endsection

@section('actions')
@endsection