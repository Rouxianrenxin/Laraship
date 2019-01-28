@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('tag_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($tag) !!}

                {!! CoralsForm::text('name','Utility::attributes.tag.name',true) !!}

                {!! CoralsForm::text('slug','Utility::attributes.tag.slug',true) !!}

                {!! CoralsForm::select('module','Utility::attributes.tag.module', \Utility::getUtilityModules()) !!}

                {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}

                {!! CoralsForm::customFields($tag, 'col-md-12') !!}

                {!! CoralsForm::formButtons() !!}

                {!! CoralsForm::closeForm($tag) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection