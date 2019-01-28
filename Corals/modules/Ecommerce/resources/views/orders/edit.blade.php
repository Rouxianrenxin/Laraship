<div class="row">
    <div class="col-md-12">
        @component('components.box')
            {!! CoralsForm::openForm($order) !!}
            <div class="row">
                <div class="col-md-6">
                    {!! CoralsForm::select('status','Ecommerce::attributes.order.status_order', $order_statuses ,true) !!}
                    {!! CoralsForm::select('shipping[status]','Ecommerce::attributes.order.shipping_status', $order_statuses ,false, $order->shipping['status'] ?? '',['class'=>'']) !!}
                    {!! CoralsForm::text('shipping[tracking_number]','Ecommerce::attributes.order.shipping_track', false, $order->shipping['tracking_number'] ?? '',['class'=>'']) !!}
                    {!! CoralsForm::text('shipping[label_url]','Ecommerce::attributes.order.shipping_label', false, $order->shipping['label_url'] ?? '',['class'=>'']) !!}
                </div>
                <div class="col-md-6">

                    {!! CoralsForm::select('billing[payment_status]','Ecommerce::attributes.order.payment_status', $payment_statuses , false, $order->billing['payment_status'] ?? '',['class'=>'']) !!}
                    {!! CoralsForm::text('billing[gateway]','Ecommerce::attributes.order.payment_method', false, $order->billing['gateway'] ?? '',['class'=>'']) !!}
                    {!! CoralsForm::text('billing[payment_reference]','Ecommerce::attributes.order.payment_reference', false, $order->billing['payment_reference'] ?? '',['class'=>'']) !!}
                    {!! CoralsForm::checkbox('notify_buyer', 'Ecommerce::attributes.order.notify_buyer') !!}

                    {!! CoralsForm::formButtons(trans('Corals::labels.save',['title' => $title_singular]), [], ['show_cancel' => false])  !!}
                </div>

            </div>
            {!! CoralsForm::closeForm($order) !!}
        @endcomponent
    </div>
</div>
