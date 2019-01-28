@extends('layouts.master')

@section('css')
@endsection

@section('title', $title_singular)

@section('hero_area')
    @include('partials.page_header', ['content'=> '<h2 class="product-title">'. $title .'</h2>'])
@endsection

@section('js')
@endsection