@extends('layouts.crud.grid')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_products') }}
        @endslot
    @endcomponent
@endsection