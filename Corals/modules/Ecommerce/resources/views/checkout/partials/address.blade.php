{!! Form::open( ['url' => url($urlPrefix.'checkout/step/billing-shipping-address'),'method'=>'POST', 'class'=>'ajax-form','id'=>'checkoutForm']) !!}
<div class="row">
    <div class="col-md-12">
        <h4>@lang('Ecommerce::labels.checkout.title')</h4>
        <hr>
        @include('components.address',['key'=>'billing_address', 'object'=> $billing_address,'type'=>'billing','container'=>'col-md-12'])
        {!! CoralsForm::checkbox('save_billing', 'Ecommerce::labels.checkout.save_shipping',true) !!}

    </div>
</div>


@if($enable_shipping)
    <div class="row">
        <div class="col-md-12">
            <h4>@lang('Ecommerce::labels.checkout.shipping_title')</h4>
            <hr>
            {!! CoralsForm::checkbox('copy_billing', 'Ecommerce::labels.checkout.copy_billing') !!}
            @include('components.address',['key'=>'shipping_address', 'object'=> $shipping_address,'type'=>'shipping','container'=>'col-md-12'])
            {!! CoralsForm::checkbox('save_shipping', 'Ecommerce::labels.checkout.save_shipping',true) !!}

        </div>
    </div>
@endif
{!! Form::close() !!}

<script>

    $(document).ready(function () {
        $('#copy_billing').change(function (event) {
            if ($(this).prop('checked')) {
                $('input[name="shipping_address[address_1]"]').val($('input[name="billing_address[address_1]"]').val());
                $('input[name="shipping_address[address_2]"]').val($('input[name="billing_address[address_2]"]').val());
                $('input[name="shipping_address[city]"]').val($('input[name="billing_address[city]"]').val());
                $('input[name="shipping_address[state]"]').val($('input[name="billing_address[state]"]').val());
                $('input[name="shipping_address[zip]"]').val($('input[name="billing_address[zip]"]').val());
                $('select[name="shipping_address[country]"]').val($('select[name="billing_address[country]"]').val());
                $('select[name="shipping_address[country]"]').trigger('change');
            }
        });
    });
</script>