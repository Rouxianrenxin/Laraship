@extends('layouts.master')


@section('editable_content')
    @unless($home)
        @include('partials.page_header')
    @endunless

    @php \Actions::do_action('pre_content',$item, $home??null) @endphp

    {!! $item->rendered !!}
@stop