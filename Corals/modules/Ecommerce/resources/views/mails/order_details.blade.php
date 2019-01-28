@extends('Notification::mail.master')

@section('body')
    {!! $body??'' !!}

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
           style="max-width:600px;">
        <tr>
            <td align="left" style="padding-top: 20px;">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="10%" align="left" bgcolor="#eeeeee"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            @lang('Ecommerce::labels.mail.amount')
                        </td>
                        <td width="10%" align="left" bgcolor="#eeeeee"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            @lang('Ecommerce::labels.mail.qt')
                        </td>
                        <td width="50%" align="left" bgcolor="#eeeeee"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            @lang('Ecommerce::labels.mail.description')
                        </td>

                        <td width="15%" align="left" bgcolor="#eeeeee"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            @lang('Ecommerce::labels.mail.sku')
                        </td>

                        <td width="15%" align="left" bgcolor="#eeeeee"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                            @lang('Ecommerce::labels.mail.type')
                        </td>
                    </tr>
                    @foreach($order->items as $item)
                        <tr>
                            <td width="10%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                {{ \Payments::currency($item->amount, $order->currency) }}
                            </td>
                            <td width="10%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                {{ $item->quantity??'-' }}
                            </td>

                            <td width="50%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                {!! $item->present('description') !!}
                                <br/>
                                {!! formatArrayAsLabels(\OrderManager::mapSelectedAttributes($item->item_options['product_options']), 'success',null,true) !!}
                            </td>
                            <td width="15%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                {{ $item->sku_code??'-' }}
                            </td>
                            <td width="15%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                {{ $item->type }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" style="padding-top: 20px;">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="75%" align="left"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                            @lang('Ecommerce::labels.mail.total')
                        </td>
                        <td width="25%" align="left"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                            {{ $order->present('amount') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @if($downloads = \OrderManager::getOrderDownloadable($order))
            <tr>
                <td align="left"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                        @lang('Ecommerce::labels.mail.download')
                    </h5>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td width="30%" align="left" bgcolor="#eeeeee"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.file')
                            </td>
                            <td width="70%" align="left" bgcolor="#eeeeee"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.description')
                            </td>
                        </tr>
                        @foreach($downloads as $download)
                            <tr id="tr_{{ $loop->index }}" data-index="{{ $loop->index }}">
                                <td>
                                    <a href="{{ url('marketplace/orders/'.$order->hashed_id.'/download/'.$download['hashed_id']) }}"
                                       target="_blank">{{ $download['name'] }}</a>
                                </td>
                                <td>
                                    {{ $download['description'] }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endif
        @if($posts = \OrderManager::getOrderPremuimContent($order))
            <tr>
                <td align="left"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                        @lang('Ecommerce::labels.mail.premium_content')
                    </h5>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    {!! CoralsForm::link(url($post->slug),'<i class="fa fa-magic"></i>  '.$post->title,['class'=>'','target'=>'_blank']) !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endif
        <tr>
            <td align="left"
                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                <h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                    @lang('Ecommerce::labels.mail.bill_address')
                </h5>
            </td>
        </tr>
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    @isset($order->billing['billing_address'])
                        <tr>
                            <td width="30%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.address_one')
                            </td>
                            <td width="70%">{{ $order->billing['billing_address']['address_1'] }}</td>
                        </tr>
                        <tr>
                            <td width="30%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.address_two')
                            </td>
                            <td>{{ $order->billing['billing_address']['address_2'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="30%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.city')
                            </td>
                            <td>{{ $order->billing['billing_address']['city'] }}</td>
                        </tr>
                        <tr>
                            <td width="30%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.state')
                            </td>
                            <td>{{ $order->billing['billing_address']['state'] }}</td>
                        </tr>
                        <tr>
                            <td width="30%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.zip')
                            </td>
                            <td>{{ $order->billing['billing_address']['zip'] }}</td>
                        </tr>
                        <tr>
                            <td width="30%" align="left"
                                style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                @lang('Ecommerce::labels.mail.country')
                            </td>
                            <td>{{ $order->billing['billing_address']['country'] }}</td>
                        </tr>
                    @endisset
                </table>
            </td>
        </tr>
        @if($order->shipping)
            <tr>
                <td align="left"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                    <h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                        @lang('Ecommerce::labels.mail.shipping_details')
                    </h5>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        @isset($order->shipping['shipping_address'])
                            <tr>
                                <td width="30%" align="left"
                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                    @lang('Ecommerce::labels.mail.address_one')
                                </td>
                                <td width="70%">{{ $order->shipping['shipping_address']['address_1'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%" align="left"
                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                    @lang('Ecommerce::labels.mail.address_two')
                                </td>
                                <td>{{ $order->shipping['shipping_address']['address_2'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td width="30%" align="left"
                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                    @lang('Ecommerce::labels.mail.city')
                                </td>
                                <td>{{ $order->shipping['shipping_address']['city'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%" align="left"
                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                    @lang('Ecommerce::labels.mail.state')
                                </td>
                                <td>{{ $order->shipping['shipping_address']['state'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%" align="left"
                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                    @lang('Ecommerce::labels.mail.zip')
                                </td>
                                <td>{{ $order->shipping['shipping_address']['zip'] }}</td>
                            </tr>
                            <tr>
                                <td width="30%" align="left"
                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 24px; padding: 10px;">
                                    @lang('Ecommerce::labels.mail.country')
                                </td>
                                <td>{{ $order->shipping['shipping_address']['country'] }}</td>
                            </tr>
                        @endisset
                    </table>
                </td>
            </tr>
            @if(isset($order->shipping['tracking_number']) && !empty($order->shipping['tracking_number']))
                <tr>
                    <td align="left"
                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                        <h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                            @lang('Ecommerce::labels.mail.tracking_num')
                        </h5>
                    </td>
                </tr>
                <tr>
                    <td align="left"
                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                        <a href="{{url(config('marketplace.models.order.resource_url').'/'.$order->hashed_id.'/track')}}"
                           class="btn btn-xs btn-primary m-r-5 m-l-5 modal-load"
                           data-title="Tracking History">{{ $order->shipping['tracking_number'] }}</a>
                    </td>
                </tr>
            @endif
            @if(isset($order->shipping['label_url']) && !empty($order->shipping['label_url']))
                <tr>
                    <td align="left"
                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                        <h5 style="font-size: 15px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                            @lang('Ecommerce::labels.mail.tracking_label')
                        </h5>
                    </td>
                </tr>
                <tr>
                    <td align="left"
                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                        <a target="_blank"
                           href="{{ $order->shipping['label_url'] }}">
                            @lang('Ecommerce::labels.mail.click_here')
                        </a>
                    </td>
                </tr>
            @endif
        @endif
    </table>
@endsection
