@extends('layouts.crud.index')

@section('actions')
    {!! CoralsForm::link(url($resource_url.'/create'),'Corals::labels.create',['class'=>'btn btn-success modal-load','data-title'=>trans('Payment::labels.tax_class.new_class_modal_title')]) !!}
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('tax_classes') }}
        @endslot
    @endcomponent
@endsection