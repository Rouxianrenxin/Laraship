@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('tax_create_edit',$tax_class) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($tax) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! CoralsForm::text('name','Payment::attributes.tax.name',true) !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::number('priority','Payment::attributes.tax.priority',true,null,['step'=>1,'min'=>0,'max'=>999999]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::number('rate','Payment::attributes.tax.rate',true,null,['right_addon'=>'<i class="fa fa-percent"></i>']) !!}
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        {!! CoralsForm::select('country', 'Payment::attributes.tax.country', \Settings::getCountriesList()) !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::text('state', 'Payment::attributes.tax.state') !!}
                    </div>
                    <div class="col-md-3">
                        {!! CoralsForm::text('zip', 'Payment::attributes.tax.zip',false) !!}
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        {!! CoralsForm::checkbox('compound', 'Payment::attributes.tax.compound',$tax->compound) !!}
                    </div>

                </div>
                {!! CoralsForm::customFields($tax) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($tax) !!}
            @endcomponent
        </div>
    </div>
@endsection