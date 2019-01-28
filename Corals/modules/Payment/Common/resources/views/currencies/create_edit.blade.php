@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('currencies_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($currency) !!}

                {!! CoralsForm::text('code','Payment::attributes.currency.code',true,$currency->code,['readonly']) !!}
                {!! CoralsForm::text('name','Payment::attributes.currency.name',true) !!}
                {!! CoralsForm::text('symbol','Payment::attributes.currency.symbol',true) !!}
                {!! CoralsForm::text('format','Payment::attributes.currency.format',true) !!}
                {!! CoralsForm::text('exchange_rate','Payment::attributes.currency.exchange_rate',true) !!}
                {!! CoralsForm::checkbox('active','Corals::attributes.status_options.active',$currency->active) !!}

                {!! CoralsForm::formButtons() !!}

                {!! CoralsForm::closeForm($currency) !!}
            @endcomponent
        </div>
    </div>
@endsection