@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_orders') }}
        @endslot
    @endcomponent
@endsection

@section('css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                @slot('box_title')
                    @lang('Ecommerce::labels.order.order_detail')
                @endslot
                <div class="table-responsive">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>@lang('Ecommerce::attributes.order.id')</th>
                            <th>@lang('Ecommerce::attributes.order.amount')</th>
                            <th>@lang('Corals::attributes.status')</th>
                            <th>@lang('Ecommerce::attributes.order.user_id')</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->present('amount') }}</td>
                            <td>{!! $order->present('status') !!}</td>
                            <td>{!!   $order->present('user_id') !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Items</h3>
                <div class="table-responsive">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>@lang('Ecommerce::attributes.order.amount')</th>
                            <th>@lang('Ecommerce::attributes.order.quantity')</th>
                            <th>@lang('Ecommerce::attributes.order.description')</th>
                            <th>@lang('Ecommerce::attributes.order.sku_code')</th>
                            <th>@lang('Ecommerce::attributes.order.type')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ \Payments::currency($item->amount, $order->currency) }}</td>
                                <td>{{ $item->quantity??'-' }}</td>
                                <td>{!!  $item->present('description') !!} <br>
                                    {!! formatArrayAsLabels(\OrderManager::mapSelectedAttributes($item->item_options['product_options']), 'success',null,true)    !!}
                                </td>
                                <td>{{ $item->sku_code??'-' }}</td>
                                <td>{{ $item->type }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if($downloads = \OrderManager::getOrderDownloadable($order))
                    <h3>@lang('Ecommerce::labels.order.download_able')</h3>
                    <div class="table-responsive">
                        <table id="downloads-table" width="100%"
                               class="table color-table info-table table table-hover table-striped table-condensed">
                            <thead>
                            <tr>
                                <th width="30%">@lang('Ecommerce::attributes.order.file')</th>
                                <th width="70%">@lang('Ecommerce::attributes.order.description')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($downloads as $download)
                                <tr id="tr_{{ $loop->index }}" data-index="{{ $loop->index }}">
                                    <td>
                                        <a href="{{ url('e-commerce/orders/'.$order->hashed_id.'/download/'.$download['hashed_id']) }}"
                                           target="_blank">{{ $download['name'] }}</a>
                                    </td>
                                    <td>
                                        {{ $download['description'] }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($order->posts))
                    <h3>@lang('Ecommerce::labels.order.private_access')</h3>
                    <ul>
                        @foreach($order->posts as $post)
                            <li>
                                {!! CoralsForm::link(url($post->slug),trans('Ecommerce::labels.order.magic',['title' => $post->title]),['class'=>'','target'=>'_blank']) !!}
                            </li>
                        @endforeach
                    </ul>
                @endif

                    {!! \Actions::do_action('ecommerce_order_post_details', $order) !!}
            @endcomponent
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    @component('components.box')
                        @slot('box_title')
                            @lang('Ecommerce::labels.order.billing_add')
                        @endslot
                        <div class="table-responsive">
                            <table class="table color-table info-table table table-hover table-striped table-condensed">
                                <tbody>
                                @isset($order->billing['billing_address'])
                                    <tr>
                                        <th>@lang('Ecommerce::attributes.order.address_one')</th>
                                        <td>{{ $order->billing['billing_address']['address_1'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Ecommerce::attributes.order.address_two')</th>
                                        <td>{{ $order->billing['billing_address']['address_2'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Ecommerce::attributes.order.city')</th>
                                        <td>{{ $order->billing['billing_address']['city'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Ecommerce::attributes.order.state')</th>
                                        <td>{{ $order->billing['billing_address']['state'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Ecommerce::attributes.order.zip')</th>
                                        <td>{{ $order->billing['billing_address']['zip'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('Ecommerce::attributes.order.country')</th>
                                        <td>{{ $order->billing['billing_address']['country'] }}</td>
                                    </tr>
                                @endisset
                                </tbody>
                            </table>
                        </div>
                        <h4> Payment Details</h4>
                        <div class="table-responsive">
                            <table class="table color-table info-table table table-hover table-striped table-condensed">

                                <tbody>
                                <tr>
                                    <th>@lang('Ecommerce::attributes.order.method')</th>
                                    <td>{{ $order->billing['gateway'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Ecommerce::attributes.order.payment_status')</th>
                                    <td>{{ $order->billing['payment_status'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Corals::attributes.status')</th>
                                    <td>{{ $order->billing['payment_reference'] ?? '-' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endcomponent
                </div>
            </div>
            @if($order->shipping)
                <div class="row">
                    <div class="col-md-12">
                        @component('components.box')
                            @slot('box_title')
                                @lang('Ecommerce::labels.order.shipping_details')
                            @endslot
                            <div class="table-responsive">
                                <table class="table color-table info-table table table-hover table-striped table-condensed">

                                    <tbody>
                                    @isset($order->shipping['shipping_address'])
                                        <tr>
                                            <th>@lang('Ecommerce::attributes.order.address_one')</th>
                                            <td>{{ $order->shipping['shipping_address']['address_1'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Ecommerce::attributes.order.address_two')</th>
                                            <td>{{ $order->shipping['shipping_address']['address_2'] ?? '-'  }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Ecommerce::attributes.order.city')</th>
                                            <td>{{ $order->shipping['shipping_address']['city'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Ecommerce::attributes.order.state')</th>
                                            <td>{{ $order->shipping['shipping_address']['state'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Ecommerce::attributes.order.zip')</th>
                                            <td>{{ $order->shipping['shipping_address']['zip'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Ecommerce::attributes.order.country')</th>
                                            <td>{{ $order->shipping['shipping_address']['country'] }}</td>
                                        </tr>
                                    @endisset
                                    @if(isset($order->shipping['tracking_number']) && !empty($order->shipping['tracking_number']))
                                        <tr>
                                            <th>@lang('Ecommerce::labels.order.tracking_num')</th>
                                            <td>
                                                <a href="{{url($resource_url.'/'.$order->hashed_id.'/track')}}"
                                                   class="btn btn-xs btn-primary m-r-5 m-l-5 modal-load"
                                                   data-title="Tracking History">{{ $order->shipping['tracking_number'] }}</a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if(isset($order->shipping['label_url']) && !empty($order->shipping['label_url']))
                                        <tr>
                                            <th>@lang('Ecommerce::labels.order.tracking_label')</th>
                                            <td>
                                                <a target="_blank"
                                                   href="{{ $order->shipping['label_url'] }}">
                                                    @lang('Ecommerce::labels.order.click_here')
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        @endcomponent
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection