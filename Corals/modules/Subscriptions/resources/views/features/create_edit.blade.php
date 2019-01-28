@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('feature_create_edit',$product) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    @php
        $customFields = CoralsForm::customFields($feature,'col-md-12');
    @endphp
    <div class="row">
        <div class="{{ !empty($customFields)?'col-md-8':'col-md-4' }}">
            @component('components.box')
                {!! CoralsForm::openForm($feature) !!}
                <div class="row">
                    <div class="{{ !empty($customFields)?'col-md-6':'col-md-12' }}">
                        {!! CoralsForm::text('name','Subscriptions::attributes.feature.name',true) !!}
                        {!! CoralsForm::text('caption','Subscriptions::attributes.feature.caption',true) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::select('type', 'Subscriptions::attributes.feature.type', trans('Subscriptions::attributes.feature.type_option'),true) !!}
                        {!! CoralsForm::text('unit','Subscriptions::attributes.feature.unit') !!}
                        {!! CoralsForm::textarea('description','Subscriptions::attributes.feature.description',true) !!}
                    </div>
                    @if(!empty($customFields))
                        <div class="col-md-6">
                            {!! $customFields !!}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($feature) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection