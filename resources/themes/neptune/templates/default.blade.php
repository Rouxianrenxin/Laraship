@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header')

    {!! $item->rendered !!}
@stop