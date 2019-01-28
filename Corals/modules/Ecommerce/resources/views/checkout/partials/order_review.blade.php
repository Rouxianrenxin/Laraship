<div class="row">
    <div class="col-md-12">
        {!! Form::open( ['url' => url($urlPrefix.'checkout'),'method'=>'POST','class'=>'ajax-form']) !!}
        <input type="hidden" name="order_id" value="{{ $order->id  }}"/>
        <div class="table-responsive">
            <table class="table color-table info-table table table-hover table-striped table-condensed">
                <thead>
                <tr>
                    <th>@lang('Ecommerce::attributes.order.order_number')</th>
                    <th>@lang('Ecommerce::attributes.order.amount')</th>
                    <th>@lang('Ecommerce::attributes.order.status_order')</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->present('amount') }}</td>
                    <td>{!! $order->present('status') !!}</td>
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
                        <td>{{ \Payments::currency($item->amount) }}</td>
                        <td>{{ $item->quantity??'-' }}</td>
                        <td>{!!   $item->description??'-' !!}</td>
                        <td>{{ $item->sku_code??'-' }}</td>
                        <td>{{ $item->type }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class=""></td>
                    <td></td>
                    <td></td>
                    <td class="small-caps table-bg" style="text-align: right">@lang('Ecommerce::labels.checkout.sub_total')</td>
                    <td id="sub_total">{{ ShoppingCart::subTotal() }}</td>
                </tr>
                <tr>
                    <td class=""></td>
                    <td></td>
                    <td></td>
                    <td class="small-caps table-bg" style="text-align: right">@lang('Ecommerce::labels.checkout.tax')</td>
                    <td id="tax_total">{{ \ShoppingCart::taxTotal() }}</td>
                </tr>

                <tr>
                    <td class=""></td>
                    <td></td>
                    <td></td>
                    <td class="small-caps table-bg" style="text-align: right">@lang('Ecommerce::labels.checkout.discount')</td>
                    <td id="total_discount">{{ ShoppingCart::totalDiscount() }}</td>
                </tr>

                <tr class="border-bottom">
                    <td class=""></td>
                    <td></td>
                    <td></td>
                    <td class="small-caps table-bg" style="text-align: right">@lang('Ecommerce::labels.checkout.total')</td>
                    <td id="total">{{ \ShoppingCart::total() }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        {!! CoralsForm::formButtons(trans('Ecommerce::labels.checkout.complete_order'), [], []) !!}
        {!! Form::close() !!}
    </div>
</div>