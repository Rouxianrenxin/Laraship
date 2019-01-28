@extends('layouts.crud.show')

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
    @component('components.box', ['box_class'=>'box-success'])
        <div class="row">
            <div class="col-md-12">
                <p>
                    <i class="fa fa-fw fa-pencil-square-o"></i>
                    @lang('Newsletter::attributes.email.subject'): <b>{{ $emailLogger->email->subject??'-' }}</b>
                </p>
                <ul class="list-unstyled list-inline">
                    <li>
                        <i class="fa fa-fw fa-envelope-o"></i>
                        @lang('Newsletter::attributes.subscriber.email')
                        : <b>{{ $emailLogger->presenter()['subscriber_email'] }}</b>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-pencil-square-o"></i>
                        @lang('Newsletter::attributes.subscriber.name'):
                        <b>{{ $emailLogger->presenter()['subscriber_name'] }}</b>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-flag-o"></i>
                        @lang('Corals::attributes.status')
                        : <b>{!! $emailLogger->presenter()['status'] !!}</b>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-clock-o"></i>
                        @lang('Corals::attributes.created_at')
                        : <b>{{ $emailLogger->presenter()['created_at'] }}</b>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-clock-o"></i>
                        @lang('Corals::attributes.updated_at')
                        : <b>{{ $emailLogger->presenter()['updated_at'] }}</b>
                    </li>
                </ul>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="table-responsive">
                    <table class="details-table">
                        <tbody>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.languages')</td>
                            <td>{{ $emailLogger->languages?join(', ', $emailLogger->languages):'-' }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.ip')</td>
                            <td>{{ $emailLogger->ip ?: '-'}}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.browser')</td>
                            <td>{{ $emailLogger->browser ?: '-'}}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.browser_version')</td>
                            <td>{{ $emailLogger->browser_version ?: '-'}}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.device_type')</td>
                            <td>{{ $emailLogger->device_type  ?: '-'}}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.device')</td>
                            <td>{{ $emailLogger->device  ?: '-'}}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.platform')</td>
                            <td>{{ $emailLogger->platform  ?: '-'}}</td>
                        </tr>
                        <tr>
                            <td>@lang('Newsletter::attributes.email_logger.platform_version')</td>
                            <td>{{ $emailLogger->platform_version  ?: '-'}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-9">
                <p>@lang('Newsletter::attributes.email.email_body'):</p>
                <div>{!! $emailLogger->email->email_body??'-' !!}</div>
            </div>
        </div>
    @endcomponent
@endsection

