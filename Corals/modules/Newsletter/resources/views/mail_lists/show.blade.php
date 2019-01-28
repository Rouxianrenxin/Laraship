@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('mail_list_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box', ['box_class'=>'box-success'])
                <p>
                    @lang('Newsletter::attributes.mail_list.name'): <b>{{ $mailList->name }}</b>
                </p>
                <p>
                    @lang('Corals::attributes.status'): {!! $mailList->presenter()['status'] !!}
                </p>
                <p>
                    @lang('Newsletter::attributes.mail_list.subscribers_count')
                    : {!! $mailList->presenter()['subscribers_count'] !!}
                </p>
                <p>
                    @lang('Corals::attributes.created_at'): {!! $mailList->presenter()['created_at'] !!}
                </p>
            @endcomponent
        </div>
    </div>
@endsection

