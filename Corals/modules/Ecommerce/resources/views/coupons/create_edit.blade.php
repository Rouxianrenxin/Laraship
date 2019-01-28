@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_coupon_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($coupon) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('code','Ecommerce::attributes.coupon.code',true) !!}
                        {!! CoralsForm::select('type', 'Ecommerce::attributes.coupon.type',trans('Ecommerce::attributes.coupon.type_option')) !!}
                        {!! CoralsForm::text('value','Ecommerce::attributes.coupon.value',true) !!}
                        {!! CoralsForm::number('min_cart_total','Ecommerce::attributes.coupon.min_cart_total') !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::date('start','Ecommerce::attributes.coupon.start',true,$coupon->start) !!}
                        {!! CoralsForm::date('expiry','Ecommerce::attributes.coupon.expiry',true,$coupon->expiry) !!}
                        {!! CoralsForm::number('uses','Ecommerce::attributes.coupon.uses',false,$coupon->exists?$coupon->uses:'', array_merge(['step'=>1,'min'=>1,'max'=>999999])) !!}
                        {!! CoralsForm::number('max_discount_value','Ecommerce::attributes.coupon.max_discount_value') !!}

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::select('users[]','Ecommerce::attributes.coupon.users', [], false, null,
                        ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
                        'model'=>\Corals\User\Models\User::class,
                        'columns'=> json_encode(['name']),
                        'selected'=>json_encode($coupon->users()->pluck('users.id')->toArray()),
                        ]],'select2') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::select('products[]','Ecommerce::attributes.coupon.products', [], false, null,
                        ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
                        'model'=>\Corals\Modules\Ecommerce\Models\Product::class,
                        'columns'=> json_encode(['name']),
                        'selected'=>json_encode($coupon->products()->pluck('ecommerce_products.id')->toArray()),
                        ]],'select2') !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($coupon, 'col-md-6') !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($coupon) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection