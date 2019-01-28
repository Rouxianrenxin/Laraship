@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! $item->rendered !!}
            </div>
        </div>
    </div>
@stop