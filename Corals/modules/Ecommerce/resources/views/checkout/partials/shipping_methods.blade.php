{!! Form::open( ['url' => url($urlPrefix.'checkout/step/shipping-method'),'method'=>'POST','files'=>true,'class'=>'ajax-form','id'=>'checkoutForm']) !!}

<div class="row">
    <div class="col-md-12 shipping-options">
        <h4>@lang('Ecommerce::labels.settings.shipping.select_method')</h4>
        @if($shipping_methods)
            {!! CoralsForm::radio('selected_shipping_method',trans('Ecommerce::attributes.shipping.shipping_method'),true, $shipping_methods ) !!}

        @else
            <div class="form-group">
                <span data-name="selected_shipping_method"></span>
            </div>
            <span class="label label-warning" data-><i class="fa fa-info-circle"></i> @lang('Ecommerce::labels.settings.shipping.no_available_shipping')</span>
        @endif
    </div>
</div>

{!! Form::close() !!}
