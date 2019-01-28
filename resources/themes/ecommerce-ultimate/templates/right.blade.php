@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header')

    <div class="container padding-bottom-3x mb-1">
        <div class="row">
            <div class="col-lg-9 col-lg-8">
                {!! $item->rendered !!}
            </div>
            <div class="col-lg-3 col-lg-4">
                @include('partials.sidebar')
            </div>
        </div>
    </div>
@stop