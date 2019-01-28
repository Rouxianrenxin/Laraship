{{ trans('corals-classified::email.product_send.received_message',['name' => $name , 'product_name'=>$product->name,'product_url'=>$product->getShowURL()]) }}

<p>
    {{ trans('corals-classified::email.product_send.user_message',['user_message' => $user_message]) }}
</p>
