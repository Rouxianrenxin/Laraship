@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('subscriber_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($subscriber) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::email('email', 'Newsletter::attributes.subscriber.email', true) !!}

                        {!! CoralsForm::text('name', 'Newsletter::attributes.subscriber.name') !!}

                        {!! CoralsForm::radio('status', 'Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                    </div>

                    <div class="col-md-6">
                        @if(!empty($mailLists = \Newsletter::getAllMailLists()))
                            {!! CoralsForm::checkboxes('mail_lists[]', 'Newsletter::attributes.subscriber.mail_lists', false, $mailLists, $subscriber->mailLists()->pluck('id')->toArray()) !!}
                        @else
                            <h4>@lang('Newsletter::exception.subscribers.no_mail_lists')</h4>
                        @endif
                    </div>
                </div>

                {!! CoralsForm::customFields($subscriber) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($subscriber) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection