@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            My Downloads
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
        <div class="col-md-12">
            @component('components.box')
                @slot('box_title')
                   @lang('Ecommerce::labels.order.download')
                @endslot

                <div class="table-responsive">
                    <table id="downloads-table" width="100%"
                           class="table color-table info-table table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th width="30%">@lang('Ecommerce::attributes.order.order_number')</th>
                            <th width="30%">@lang('Ecommerce::attributes.order.file')</th>
                            <th width="70%">@lang('Ecommerce::attributes.order.description')</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                            @if($downloads = \OrderManager::getOrderDownloadable($order))

                                @foreach($downloads as $download)
                                    <tr id="tr_{{ $loop->index }}" data-index="{{ $loop->index }}">
                                        <td>
                                            {!! $order->present('order_number') !!}
                                        </td>
                                        <td>
                                            <a href="{{ url('e-commerce/orders/'.$order->hashed_id.'/download/'.$download['hashed_id']) }}"
                                               target="_blank">{{ $download['name'] }}</a>
                                        </td>
                                        <td>
                                            {{ $download['description'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
@endsection
@section('js')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#downloads-table').DataTable({});
        });
    </script>
@endsection