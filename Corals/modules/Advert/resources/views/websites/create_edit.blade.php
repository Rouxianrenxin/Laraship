@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('website_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($website) !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::text('name','Advert::attributes.website.name',true) !!}
                        {!! CoralsForm::text('url','Advert::attributes.website.url',true) !!}

                        {!! CoralsForm::text('contact','Advert::attributes.website.contact',true) !!}
                        {!! CoralsForm::email('email','Advert::attributes.website.email',true) !!}

                        {!! CoralsForm::radio('status', 'Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}

                        {!! CoralsForm::textarea('notes', 'Advert::attributes.website.notes', false, null,['rows'=>4]) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($website, 'col-md-12') !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($website) !!}
            @endcomponent
        </div>
    </div>
@endsection