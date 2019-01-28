@extends('layouts.master')

@section('editable_content')
    @php \Actions::do_action('pre_content', null, null) @endphp
    <h3 class="title mb-3">@lang('corals-ecommerce-mimity::labels.template.cart.product')</h3>

    @if(count(ShoppingCart::getItems()) > 0)
        <table class="table table-cart">
            <tbody>
            @foreach(\ShoppingCart::getItems() as $item)
                <tr id="item-{{$item->getHash()}}">
                    <td>
                        <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                           class="btn btn-sm btn-outline-warning rounded-circle" data-action="post"
                           data-request_data='@json(["action"=>"removeItem"])'
                           data-page_action="updateCart" data-style="zoom-in"
                           data-toggle="tooltip"
                           title="Remove item">
                            <i class="fa fa-close"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ url('shop', [$item->id->product->slug]) }}"><img src="{{ $item->id->image }}"
                                                                                     alt="SKU Image"
                                                                                     height="50"
                                                                                     style="width: auto;"></a>
                        <button class="btn btn-sm btn-outline-warning rounded">Remove</button>
                    </td>
                    <td>
                        <h6><a href="{{ url('shop', [$item->id->product->slug]) }}"
                               class="text-body">
                                {!!  $item->id->product->name !!} [{{$item->id->code }}]
                            </a>
                            {!!  $item->id->presenter()['options']  !!}
                            {!! formatArrayAsLabels(\OrderManager::mapSelectedAttributes($item->product_options), 'success',null,true)    !!}

                        </h6>
                        <h6 class="text-muted">{{ \Payments::currency($item->qty * $item->price) }}</h6>

                    </td>
                    <td>
                        <div class="input-spinner">
                            <input step="1" min="1" class="form-control form-control-sm cart-quantity"
                                   style="width:60px;display: inline;text-align:center" type="number"
                                   name="quantity"
                                   data-id="{{ $item->rowId }}"
                                   {!! $item->id->allowed_quantity>0?('max="'.$item->id->allowed_quantity.'"'):'' !!} value="{{ $item->qty }}"/>
                            @if($item->id->allowed_quantity != 1)
                                <form action="{{ url('cart/quantity', [$item->getHash()]) }}" method="POST"
                                      class="ajax-form form-inline" data-page_action="updateCart">
                                    {{ csrf_field() }}
                                    <div class="btn-group-vertical">
                                        <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                           class="btn btn-light"
                                           title="Remove One" data-action="post" data-style="zoom-in"
                                           data-request_data='@json(["action"=>"decreaseQuantity"])'
                                           data-page_action="updateCart">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                           class="btn btn-light" data-style="zoom-in"
                                           title="Add One" data-action="post" data-page_action="updateCart"
                                           data-request_data='@json(["action"=>"increaseQuantity"])'>
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
                                    </div>
                                </form>
                            @else
                                <input style="width:40px;text-align: center;"
                                       value="1"
                                       disabled/>
                            @endif
                        </div>
                        <span class="price"
                              id="item-total-{{$item->getHash()}}">
                            {{ \Payments::currency($item->qty * $item->price) }}
                        </span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <div class="box-total">
                        <a class="btn btn-outline-secondary" href="{{ url('shop') }}"><i
                                    class="icon-arrow-left"></i>&nbsp; @lang('corals-ecommerce-mimity::labels.template.cart.back_shopping')
                        </a>
                        <h4>@lang('corals-ecommerce-mimity::labels.template.cart.subtotal') <span
                                    class="price" id="total">{{ ShoppingCart::subTotal() }}</span></h4>
                        <a href="{{ url('checkout') }}"
                           class="btn btn-success">@lang('corals-ecommerce-mimity::labels.template.cart.checkout')</a>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
    @endif
    @include('partials.featured_products',['title'=>trans('corals-ecommerce-mimity::labels.template.cart.title')])

@stop

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection