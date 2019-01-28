@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('product_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($product,['files'=>true]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Subscriptions::attributes.product.name',true) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::checkbox('require_shipping_address', 'Subscriptions::attributes.product.require_shipping_address',$product->require_shipping_address) !!}
                        {!! CoralsForm::textarea('description','Subscriptions::attributes.product.description',true) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::file('image', 'Subscriptions::attributes.product.image') !!}
                        <img src="{{ $product->image }}" class="img-responsive" width="150"
                             alt="Product Image"/>
                        @if($product->exists && $product->getFirstMedia('product-image'))
                            {!! CoralsForm::checkbox('clear', 'Subscriptions::attributes.product.clear' ) !!}
                        @endif
                    </div>
                </div>
                {!! CoralsForm::customFields($product,'col-md-6') !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($product) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection