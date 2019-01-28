@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('referral_link_create_edit',$referral_program) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($referral_link,['url' => url($resource_url),'method'=>'POST']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h5>
                                <i class="fa fa-info-circle"></i>
                                {!! trans('ReferralProgram::labels.about_create_referral',['name' => $referral_program->name])  !!}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::button('ReferralProgram::labels.create_referral_link',['class'=>'btn btn-success','id'=>'payment-form-btn'], 'submit') !!}
                        {!! CoralsForm::link(url('referral/referral-programs'),'Corals::labels.cancel',['class'=>'btn btn-warning','id'=>'cancel-btn']) !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($referral_link) !!}
            @endcomponent
        </div>
    </div>
@endsection