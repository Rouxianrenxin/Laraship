@extends('layouts.master')

@section('editable_content')

    @php \Actions::do_action('pre_content',$item, $home??null) @endphp
    {!! $item->rendered !!}
@stop