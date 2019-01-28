@extends('layouts.public')

@section('editable_content')
    @php \Actions::do_action('pre_content', null, null) @endphp
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-12">
                <br><br>
                <h2 style="color:#0fad00">@lang('corals-marketplace-master::labels.template.checkout_success.success')</h2>
                <p style="font-size:20px;color:#5C5C5C;">@lang('corals-marketplace-master::labels.template.checkout_success.order_has_been_placed')</p>
                <a href="{{ url('marketplace/orders/my') }}"
                   class="btn btn-success">@lang('corals-marketplace-master::labels.template.checkout_success.go_my_order')</a>
                <br><br>
            </div>

        </div>
    </div>
@stop
