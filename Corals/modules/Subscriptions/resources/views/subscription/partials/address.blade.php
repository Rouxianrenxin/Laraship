<div class="row">
    <div class="col-md-12">
        <h4>@lang('Corals::labels.address_label.bill_address')</h4>
        <hr>
        @include('components.address',['key'=>'billing_address', 'object'=> $billing_address,'type'=>'billing','container'=>'col-md-12'])
        {!! CoralsForm::checkbox('save_billing', 'Corals::labels.address_label.save_billing',true) !!}

    </div>
</div>

@if($enable_shipping)
    <div class="row">
        <div class="col-md-12">
            <h4>@lang('Corals::labels.address_label.shipping_title')</h4>
            <hr>
            {!! CoralsForm::checkbox('copy_billing', 'Corals::labels.address_label.copy_billing') !!}
            @include('components.address',['key'=>'shipping_address', 'object'=> $shipping_address,'type'=>'shipping','container'=>'col-md-12'])
            {!! CoralsForm::checkbox('save_shipping', 'Corals::labels.address_label.save_shipping',true) !!}

        </div>
    </div>
@endif

