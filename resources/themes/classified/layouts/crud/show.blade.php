@extends('layouts.master')

@section('css')
@endsection

@section('title', $title_singular)

@section('hero_area')
    @include('partials.page_header', ['content'=> '<h2 class="product-title">'. $title .'</h2>'])
@endsection

@section('actions')
    @isset($edit_url)
        {!! CoralsForm::link(url($edit_url), trans('Corals::labels.edit'), ['class'=>'btn btn-primary']) !!}
    @endisset
@endsection

@section('js')
@endsection