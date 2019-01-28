@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('mail_list_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($mailList) !!}

                {!! CoralsForm::text('name', 'Newsletter::attributes.mail_list.name', true) !!}

                {!! CoralsForm::radio('status',trans('Corals::attributes.status'), true, trans('Corals::attributes.status_options')) !!}

                {!! CoralsForm::customFields($mailList, 'col-md-12') !!}

                {!! CoralsForm::formButtons() !!}

                {!! CoralsForm::closeForm($mailList) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection