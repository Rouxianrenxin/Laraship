@extends('layouts.master')

@section('css')
@endsection

@section('title', $title_singular)

@section('actions')
    @isset($edit_url)
        {!! CoralsForm::link(url($edit_url), trans('Corals::labels.edit'), ['class'=>'btn btn-primary']) !!}
    @endisset
@endsection

@section('js')
@endsection