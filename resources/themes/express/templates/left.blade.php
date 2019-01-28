@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header')
    
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @include('partials.sidebar')
            </div>
            <div class="col-md-8">
                {!! $item->rendered !!}
            </div>
        </div>
    </div>
@stop