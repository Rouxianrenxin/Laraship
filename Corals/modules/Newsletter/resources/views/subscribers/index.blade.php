@extends('layouts.crud.index')

@section('actions')
    @parent
    {!! CoralsForm::link(url('newsletter/import-subscribers'),'Newsletter::labels.subscriber.import_subscribers',['class'=>'btn btn btn-primary ']) !!}
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('subscribers') }}
        @endslot
    @endcomponent
@endsection

@section('custom-actions')
    @if(session()->has('import-subscribers-report'))
        <div class="row">
            <div class="col-md-12">
                {!! CoralsForm::link(url('newsletter/import-subscribers-report/download'),'Newsletter::labels.subscriber.download_import_report',['class'=>'btn btn-info','target'=>'_blank']) !!}
                {!! CoralsForm::link(url('newsletter/import-subscribers-report/clear'),'Newsletter::labels.subscriber.clear_import_report',['class'=>'btn btn-warning']) !!}
            </div>
        </div>
    @endif
@endsection