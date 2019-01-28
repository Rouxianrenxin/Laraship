@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('transaction_create_edit',$transaction) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-6">
            @component('components.box')
                {!! CoralsForm::openForm($transaction) !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::select('type', 'Payment::attributes.transaction.type', trans('Payment::attributes.transaction.types'), true) !!}
                    </div>
                    <div class="col-md-12">

                        {!! CoralsForm::number('amount', 'Payment::attributes.transaction.amount', false, null ,
                        ['step'=>0.01,  'left_addon'=>'<span class="fa fa-money"></span>']) !!}
                    </div>

                    <div class="col-md-12">
                        {!! CoralsForm::textarea('notes', 'Payment::attributes.transaction.notes',true) !!}
                    </div>
                    <div class="col-md-12">
                        {!! CoralsForm::text('reference', 'Payment::attributes.transaction.reference') !!}
                    </div>
                    <div class="col-md-12">
                        {!! CoralsForm::select('status','Payment::attributes.transaction.status',  trans('Payment::status.transaction'),true  ) !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($transaction) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($transaction) !!}
            @endcomponent
        </div>
    </div>
@endsection