@extends('layouts.master')



@section('editable_content')
    @php \Actions::do_action('pre_content', null, null) @endphp
    <section class="my-3">
        <div class="container">
            @if (count(ShoppingCart::getItems()) > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table color-table info-table table table-hover table-striped table-condensed table-cart ">
                                <thead>
                                <tr>
                                    <th colspan="2">@lang('corals-compo::labels.template.cart.product')</th>
                                    <th>@lang('corals-compo::labels.template.cart.price')</th>
                                    <th>@lang('corals-compo::labels.template.cart.quantity')</th>
                                    <th>
                                        <a class="btn btn-sm btn-outline-danger" href="{{ url('cart/empty') }}"
                                           title="Delete" data-action="post" data-page_action="site_reload">
                                            @lang('corals-compo::labels.template.cart.clear_cart')
                                        </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach (\ShoppingCart::getItems() as $item)
                                    <tr id="item-{{$item->getHash()}}">
                                        <td>
                                            <a href="{{ url('shop', [$item->id->product->slug]) }}"
                                               class="product-link float-left">
                                                <img src="{{ $item->id->image }}" alt="SKU Image"
                                                     class="product-image"
                                                     style="border-radius: 0%"/>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="product-info d-inline-block">
                                                <h4 class="product-title">
                                                    <a href="{{ url('shop', [$item->id->product->slug]) }}">
                                                        {!! $item->id->product->name !!} [{{$item->id->code }}]
                                                    </a>
                                                </h4>
                                                {!!  $item->id->presenter()['options']  !!}
                                                {!! formatArrayAsLabels(\OrderManager::mapSelectedAttributes($item->product_options), 'success',null,true)    !!}
                                            </div>
                                        </td>
                                        <td id="item-total-{{$item->getHash()}}"> {{ \Payments::currency($item->qty * $item->price) }}</td>
                                        <td class="text-center" style="width: 220px">
                                            <div class="">
                                                @if($item->id->allowed_quantity != 1)
                                                    <form action="{{ url('cart/quantity', [$item->getHash()]) }}"
                                                          method="POST"
                                                          class="ajax-form" data-page_action="updateCart">
                                                        {{ csrf_field() }}
                                                        <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                                           class="btn btn-sm btn-warning item-button"
                                                           title="Remove One" data-action="post" data-style="zoom-in"
                                                           data-request_data='@json(["action"=>"decreaseQuantity"])'
                                                           data-page_action="updateCart">
                                                            <i class="fa fa-fw fa-minus"></i>
                                                        </a>
                                                        <input step="1" min="1"
                                                               class="form-control form-control-sm cart-quantity"
                                                               style="width:60px;display: inline;text-align:center"
                                                               type="number"
                                                               name="quantity"
                                                               data-id="{{ $item->rowId }}"
                                                               {!! $item->id->allowed_quantity>0?('max="'.$item->id->allowed_quantity.'"'):'' !!} value="{{ $item->qty }}"/>
                                                        <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                                           class="btn btn-sm btn-success item-button"
                                                           data-style="zoom-in"
                                                           title="Add One" data-action="post"
                                                           data-page_action="updateCart"
                                                           data-request_data='@json(["action"=>"increaseQuantity"])'>
                                                            <i class="fa fa-fw fa-plus"></i>
                                                        </a>
                                                    </form>
                                                @else
                                                    <input style="width:40px;text-align: center;"
                                                           value="1"
                                                           disabled/>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a class="product-link remove-from-cart item-button"
                                               href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                               data-action="post" data-style="zoom-in"
                                               data-request_data='@json(["action"=>"removeItem"])'
                                               data-page_action="updateCart"
                                               data-toggle="tooltip"
                                               title="Remove item">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="shopping-cart-footer col-12">
                        <div class="col-6 float-left width-100">
                            <div class="column"><a class="btn btn-success"
                                                   href="{{ url('shop') }}">@lang('corals-compo::labels.template.cart.back_shopping')</a>
                            </div>
                        </div>
                        <div class="col-6 float-left text-right">@lang('corals-compo::labels.template.cart.subtotal')
                            <span class="text-medium" id="total">
                        {{ ShoppingCart::subTotal() }}
                        </span>
                            <a href="{{ url('checkout') }}" class="btn btn-primary"
                               style="margin-left: 8px">@lang('corals-compo::labels.template.cart.checkout')</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3>@lang('corals-compo::labels.template.cart.have_no_item')</h3>

                        <a href="{{ url('shop') }}"
                           class="btn btn-light">@lang('corals-compo::labels.template.cart.continue_shopping')</a>
                    </div>
                </div>
            @endif
        </div>
        @include('partials.featured_products')
    </section>
@stop

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection