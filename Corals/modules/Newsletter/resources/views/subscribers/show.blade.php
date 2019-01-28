@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('subscriber_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box', ['box_class'=>'box-success'])
                <p>
                    @lang('Newsletter::attributes.subscriber.email'): <b>{{ $subscriber->email }}</b>
                </p>
                <p>
                    @lang('Newsletter::attributes.subscriber.name'): <b>{{ $subscriber->name??'-' }}</b>
                </p>
                <p>
                    @lang('Newsletter::attributes.subscriber.mail_lists_count')
                    : {!! $subscriber->presenter()['mail_lists_count'] !!}
                </p>
                <p>
                    @lang('Corals::attributes.created_at'): {!! $subscriber->presenter()['created_at'] !!}
                </p>
            @endcomponent
        </div>
    </div>
@endsection

