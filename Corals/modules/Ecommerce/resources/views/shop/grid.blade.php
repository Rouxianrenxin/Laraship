@extends('layouts.crud.grid')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_shop') }}
        @endslot
    @endcomponent
@endsection

@section('actions')
@endsection


@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection