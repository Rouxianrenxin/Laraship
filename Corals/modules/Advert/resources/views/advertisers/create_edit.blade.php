@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('advertiser_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($advertiser) !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::text('name','Advert::attributes.advertiser.name',true) !!}

                        {!! CoralsForm::text('contact','Advert::attributes.advertiser.contact',true) !!}
                        {!! CoralsForm::email('email','Advert::attributes.advertiser.email',true) !!}

                        {!! CoralsForm::radio('status', 'Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}

                        {!! CoralsForm::textarea('notes', 'Advert::attributes.advertiser.notes', false, null,['rows'=>4]) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($advertiser, 'col-md-12') !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($advertiser) !!}
            @endcomponent
        </div>
    </div>
@endsection