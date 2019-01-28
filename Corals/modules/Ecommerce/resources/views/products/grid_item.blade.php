@component('components.box')
    <div style="font-size: medium" class="text-center">
        @if($item->type=="variable")
            <p class="pull-left"><a href="{{url($resource_url.'/'.$item->hashed_id.'/sku')}}"><span
                            class="label label-info">{{$item->sku->count()  }}
                        @lang('Ecommerce::labels.product.variations') </span></a></p>
        @endif
        {!! $item->present('action') !!}
        <div class="clearfix" style="height: 35px;"></div>

        <img class="img-responsive" style="display: inline;max-height: 200px;" src="{{ asset($item->image) }}"
             alt="Product Image">
    </div>

    <h3 class="text-center">{!! $item->present('name') !!}</h3>
    <div>
        <ul class="list-inline">
            <li>
                <small class="text-muted">@lang('Ecommerce::attributes.product.price'):</small>
                <b>{!!   $item->price !!}</b>
            </li>
            <li>
                <small class="text-muted">@lang('Corals::attributes.status'):</small>
                <b>{!!   $item->present('status') !!}</b>
            </li>
            <li>
                <small class="text-muted">@lang('Ecommerce::attributes.product.type'):</small>
                <b>{!!   ucfirst($item->type) !!}</b>
            </li>
        </ul>
    </div>
    <p>
        <small class="text-muted">@lang('Ecommerce::attributes.product.categories'):</small>
        <b>{!!   $item->present('categories') !!}</b>
    </p>
    <p>
        <small class="text-muted">@lang('Ecommerce::attributes.product.tags'):</small>
        <b>{!!   $item->present('tags') !!}</b>
    </p>
    @if($item->gateway_status == 'failed')
        <p>
            <small class="text-muted">@lang('Ecommerce::attributes.product.gateway_status'):</small>
            {!! $item->present('gateway_status') !!}
        </p>
    @endif
    <div>
        <ul class="list-inline">
            <li>
                <small class="text-muted">@lang('Ecommerce::attributes.product.global_option'):</small>
                <br/>{!!  $item->present('global_options')  !!}
            </li>
            <li>
                @if($item->type == 'variable')
                    <small class="text-muted">@lang('Ecommerce::attributes.product.variation_option'):</small>
                    <br/>{!!  $item->present('variation_options')  !!}
                @endif
            </li>
        </ul>
    </div>
    <p>
        <small class="text-muted">@lang('Ecommerce::attributes.product.caption'):</small>
        <br/>{{ $item->caption }}
    </p>
    <p>
        <small class="text-muted">@lang('Ecommerce::attributes.product.description'):</small>
        <br/>
        {!! str_limit(strip_tags($item->description)) !!}
        <a href="{{ url("{$resource_url}/{$item->hashed_id}") }}">@lang('Ecommerce::labels.product.more')</a>
    </p>
@endcomponent