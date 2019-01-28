@extends('layouts.crud.show')

@section('css')
    {!! Charts::styles() !!}
    {!! Charts::scripts() !!}
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('email_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @component('components.box', ['box_class'=>'box-info'])
        <div class="row">
            <div class="col-md-3">
                @widget('email_logger_by_status',['email'=> $email])
            </div>
            <div class="col-md-3">
                @widget('email_logger_by_browser',['email'=> $email])
            </div>
            <div class="col-md-3">
                @widget('email_logger_by_platform',['email'=> $email])
            </div>
            <div class="col-md-3">
                @widget('email_logger_by_device_type',['email'=> $email])
            </div>
        </div>
    @endcomponent
    <div class="row">
        <div class="col-md-12">
            @component('components.box', ['box_class'=>'box-success'])
                <p>
                    <i class="fa fa-fw fa-pencil-square-o"></i>
                    @lang('Newsletter::attributes.email.subject'): <b>{{ $email->subject }}</b>
                </p>
                <ul class="list-unstyled list-inline">
                    <li>
                        <i class="fa fa-fw fa-flag-o"></i>
                        @lang('Corals::attributes.status'): <b>{!! $email->presenter()['status'] !!}</b>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-clock-o"></i>
                        @lang('Corals::attributes.created_at'): <b>{{ $email->presenter()['created_at'] }}</b>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-clock-o"></i>
                        @lang('Corals::attributes.updated_at'): <b>{{ $email->presenter()['updated_at'] }}</b>
                    </li>
                </ul>
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <p>@lang('Newsletter::attributes.email.mail_lists'):</p>
                        <div>{!! $email->presenter()['mail_lists'] !!}</div>
                    </div>
                    <div class="col-md-6">
                        <p>@lang('Newsletter::attributes.email.subscribers'):</p>
                        <div>{!! $email->presenter()['subscribers'] !!}</div>
                    </div>
                </div>
                <hr/>
                <p>@lang('Newsletter::attributes.email.email_body'):</p>
                <div>{!! $email->presenter()['email_body'] !!}</div>
            @endcomponent
        </div>
    </div>
@endsection