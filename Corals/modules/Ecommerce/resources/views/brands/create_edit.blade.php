@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_brand_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($brand,['files'=>true]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Ecommerce::attributes.brand.name',true) !!}
                        {!! CoralsForm::text('slug','Ecommerce::attributes.brand.slug',true) !!}
                        {!! CoralsForm::checkbox('is_featured', 'Ecommerce::attributes.brand.is_featured', $brand->is_featured) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                    </div>
                    <div class="col-md-6">
                        @if($brand->hasMedia($brand->mediaCollectionName))
                            <img src="{{ $brand->thumbnail }}" class="img-responsive" style="max-width: 100%;"
                                 alt="Thumbnail"/>
                            <br/>
                            {!! CoralsForm::checkbox('clear', 'Ecommerce::attributes.brand.clear') !!}
                        @endif
                        {!! CoralsForm::file('thumbnail', 'Ecommerce::attributes.brand.thumbnail') !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($brand, 'col-md-12') !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}

                    </div>
                </div>
                {!! CoralsForm::closeForm($brand) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection