@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_shipping_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($shipping) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','Ecommerce::attributes.shipping.name',true,null,['help_text'=>'Ecommerce::attributes.shipping.help_shipping_name']) !!}
                        {!! CoralsForm::select('country', 'Ecommerce::attributes.shipping.country', \Settings::getCountriesList(),false , null,['placeholder'=>'Ecommerce::labels.shipping.place_holder']) !!}
                        {!! CoralsForm::select('shipping_method', 'Ecommerce::attributes.shipping.shipping_method', \Shipping::getShippingMethods() , true) !!}
                        {!! CoralsForm::number('min_order_total','Ecommerce::attributes.shipping.min_order_total',false,$shipping->min_order_total ?? 0.0,
                       array_merge(['help_text'=>'Ecommerce::attributes.shipping.help','right_addon'=>'<i class="fa fa-fw fa-'.strtolower(  \Payments::admin_currency_code()).'"></i>',
                       'step'=>0.01,'min'=>0,'max'=>999999])) !!}
                        {!! CoralsForm::checkbox('exclusive', 'Ecommerce::attributes.shipping.exclusive', $shipping->exclusive,1, ['help_text'=>'Ecommerce::attributes.shipping.help_exclusive'] ) !!}


                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::number('priority','Ecommerce::attributes.shipping.priority',true,null,['step'=>1,'min'=>0,'max'=>999999,'help_text'=>'Ecommerce::attributes.shipping.help_num_higher']) !!}

                        {!! CoralsForm::number('rate','Ecommerce::attributes.shipping.rate',false,$shipping->rate ?? 0.0,
array_merge(['help_text'=>'Ecommerce::attributes.shipping.help','right_addon'=>'<i class="fa fa-fw fa-'.strtolower(  \Payments::admin_currency_code()).'"></i>',
'step'=>0.01,'min'=>0,'max'=>999999])) !!}
                        {!! CoralsForm::textarea('description','Ecommerce::attributes.shipping.description',false,null,['rows'=>3]) !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($shipping, 'col-md-6') !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($shipping) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection