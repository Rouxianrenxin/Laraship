@if($tracking)
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                    <tr>
                        <th>@lang('Corals::attributes.status')</th>
                        <th>@lang('Ecommerce::labels.order.desc')</th>
                        <th>@lang('Ecommerce::labels.order.date')</th>
                        <th>@lang('Ecommerce::labels.order.loc')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $tracking['status'] }}</td>
                        <td>{{ $tracking['status_details'] }}</td>
                        <td>{{ $tracking['status_date'] }}</td>
                        <td>{{ $tracking['status_location']['city'] }}
                            - {{ $tracking['status_location']['state'] }}
                            - {{ $tracking['status_location']['zip'] }}
                            - {{$tracking['status_location']['country'] }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h3>@lang('Ecommerce::labels.order.history')</h3>
            <div class="table-responsive">
                <table class="table color-table info-table table table-hover table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>@lang('Corals::attributes.status')</th>
                        <th>@lang('Ecommerce::labels.order.desc')</th>
                        <th>@lang('Ecommerce::labels.order.date')</th>
                        <th>@lang('Ecommerce::labels.order.loc')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tracking['history'] as $tracking_item)
                        <tr>
                            <td>{{ $tracking_item['status'] }}</td>
                            <td>{{ $tracking_item['status_details'] }}</td>
                            <td>{{ $tracking_item['status_date'] }}</td>
                            <td>{{$tracking_item['status_location']['city'] }}
                                - {{$tracking_item['status_location']['state'] }}
                                - {{$tracking_item['status_location']['zip'] }}
                                - {{$tracking_item['status_location']['country'] }} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <span class="">
               @lang('Ecommerce::labels.order.no_track')
      </span>

@endif