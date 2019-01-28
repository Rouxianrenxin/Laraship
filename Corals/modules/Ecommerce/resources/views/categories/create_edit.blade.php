@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_category_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($category, ['files'=>true]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Ecommerce::attributes.category.name',true) !!}
                        {!! CoralsForm::text('slug','Ecommerce::attributes.category.slug',true) !!}
                        {!! CoralsForm::text('external_id','Ecommerce::attributes.category.external_id',false) !!}
                        {!! CoralsForm::textarea('description','Ecommerce::attributes.category.description', false) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::select('parent_id', 'Ecommerce::attributes.category.parent_cat', \Ecommerce::getCategoriesList(true, false, null, $category->exists?[$category->id]:[]), false, null, [], 'select2') !!}
                        {!! CoralsForm::checkbox('is_featured', 'Ecommerce::attributes.category.is_featured', $category->is_featured) !!}
                        @if($category->hasMedia($category->mediaCollectionName))
                            <img src="{{ $category->thumbnail }}" class="img-responsive" style="max-width: 100%;"
                                 alt="Thumbnail"/>
                            <br/>
                            {!! CoralsForm::checkbox('clear', 'Ecommerce::attributes.category.clear') !!}
                        @endif
                        {!! CoralsForm::file('thumbnail', 'Ecommerce::attributes.category.thumbnail') !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($category, 'col-md-6') !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($category) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection