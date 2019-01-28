@extends('layouts.master')

@section('editable_content')

    @php \Actions::do_action('pre_content', null, null) @endphp

    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1 mt-30">
        @if (count(ShoppingCart::getItems()) > 0)
            <div class="table-responsive shopping-cart">
                <table class="table color-table info-table table table-hover table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>@lang('corals-ecommerce-ultimate::labels.template.cart.product')</th>
                        <th class="text-center"
                            width="200">@lang('corals-ecommerce-ultimate::labels.template.cart.quantity')</th>
                        <th class="text-center">@lang('corals-ecommerce-ultimate::labels.template.cart.price')</th>
                        <th class="text-center">
                            <a class="btn btn-sm btn-outline-danger" href="{{ url('cart/empty') }}"
                               title="Delete" data-action="post" data-page_action="site_reload">
                                @lang('corals-ecommerce-ultimate::labels.template.cart.clear_cart')
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (\ShoppingCart::getItems() as $item)
                        <tr id="item-{{$item->getHash()}}">
                            <td>
                                <div class="product-item">
                                    <a class="product-thumb" href="{{ url('shop', [$item->id->product->slug]) }}">
                                        <img src="{{ $item->id->image }}" alt="SKU Image" class="mx-auto"
                                             style="max-height: 100px;width: auto;">
                                    </a>
                                    <div class="product-info">
                                        <h4 class="product-title">
                                            <a href="{{ url('shop', [$item->id->product->slug]) }}">
                                                {!! $item->id->product->name !!} [{{$item->id->code }}]
                                            </a>
                                        </h4>
                                        {!!  $item->id->presenter()['options']  !!}
                                        {!! formatArrayAsLabels(\OrderManager::mapSelectedAttributes($item->product_options), 'success',null,true)    !!}
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="">
                                    @if($item->id->allowed_quantity != 1)
                                        <form action="{{ url('cart/quantity', [$item->getHash()]) }}" method="POST"
                                              class="ajax-form form-inline" data-page_action="updateCart">
                                            {{ csrf_field() }}
                                            <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                               class="btn btn-sm btn-warning item-button"
                                               title="Remove One" data-action="post" data-style="zoom-in"
                                               data-request_data='@json(["action"=>"decreaseQuantity"])'
                                               data-page_action="updateCart">
                                                <i class="fa fa-fw fa-minus"></i>
                                            </a>
                                            <input step="1" min="1" class="form-control form-control-sm cart-quantity"
                                                   style="width:60px;display: inline;text-align:center" type="number"
                                                   name="quantity"
                                                   data-id="{{ $item->rowId }}"
                                                   {!! $item->id->allowed_quantity>0?('max="'.$item->id->allowed_quantity.'"'):'' !!} value="{{ $item->qty }}"/>
                                            <a href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                               class="btn btn-sm btn-success item-button" data-style="zoom-in"
                                               title="Add One" data-action="post" data-page_action="updateCart"
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
                            <td class="text-center text-lg text-medium" id="item-total-{{$item->getHash()}}">
                                {{ \Payments::currency($item->qty * $item->price) }}
                            </td>
                            <td class="text-center">
                                <a class="remove-from-cart item-button"
                                   href="{{ url('cart/quantity', [$item->getHash()]) }}"
                                   data-action="post" data-style="zoom-in"
                                   data-request_data='@json(["action"=>"removeItem"])'
                                   data-page_action="updateCart"
                                   data-toggle="tooltip"
                                   title="Remove item">
                                    <i class="icon-x"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="shopping-cart-footer">
                <div class="column">
                    <div class="column"><a class="btn btn-outline-secondary" href="{{ url('shop') }}"><i
                                    class="icon-arrow-left"></i>&nbsp; @lang('corals-ecommerce-ultimate::labels.template.cart.back_shopping')
                        </a></div>
                </div>
                <div class="column text-lg">@lang('corals-ecommerce-ultimate::labels.template.cart.subtotal')
                    <span class="text-medium" id="total">
                        {{ ShoppingCart::subTotal() }}
                    </span>
                    <a class="btn btn-success"
                       href="{{ url('checkout') }}">@lang('corals-ecommerce-ultimate::labels.template.cart.checkout')</a>
                </div>
            </div>
            {{--<div class="shopping-cart-footer">--}}
            {{--</div>--}}
        @else
            <div class="text-center">
                <h3>@lang('corals-ecommerce-ultimate::labels.template.cart.have_no_item')</h3>
                <a href="{{ url('shop') }}" class="btn btn-primary btn">
                    <i class="fa fa-shopping-cart fa-fw"></i>@lang('corals-ecommerce-ultimate::labels.template.cart.continue_shopping')
                </a>
            </div>
        @endif

        @include('partials.featured_products',['title'=>trans('corals-ecommerce-ultimate::labels.template.cart.title')])
    </div>
@stop

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection
