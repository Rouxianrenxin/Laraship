@component('components.box')
    <div style="font-size: medium" class="">
        {!! $item->presenter()['action'] !!}
        <ul class="list-inline">
            <li style="padding-right:0;" class="d-inline">
                <a href="{{url('/subscriptions/products/'.$item->hashed_id.'/plans')}}"> <span
                            class="label label-info badge badge-info p-r-10 p-l-10 p-t-5 p-b-5"><i
                                class="fa fa-fw fa-puzzle-piece"></i> {{ trans('Subscriptions::labels.product.plan',['count_plan' => $item->plans->count()]) }}</span></a>
            </li>
            <li style="padding-right:0;" class="d-inline">
                <a href="{{url('/subscriptions/products/'.$item->hashed_id.'/features')}}"><span
                            class="label label-primary badge badge-primary p-r-10 p-l-10 p-t-5 p-b-5"><i
                                class="fa fa-fw fa-star"></i>{{ trans('Subscriptions::labels.feature.label_feature',['count_feature' => $item->features->count()]) }}</span></a>
            </li>
        </ul>
    </div>
    <div class="m-b-20 text-center">
        <img class="img-responsive" style="display: inline;" width="150" src="{{ asset($item->image) }}"
             alt="Product Image">
    </div>

    <h3 class="text-center">{{ $item->name }}</h3>
    <p>
        <small class="text-muted">@lang('Corals::attributes.status'):</small>
        <b>{!! $item->presenter()['status'] !!}</b>
    </p>
    <p>
        <small class="text-muted">@lang('Subscriptions::attributes.product.short_code'):</small>
        <b id="shortcode_{{$item->id}}">{{ $item->presenter()['short_code'] }}</b>

        <a href="#" onclick="event.preventDefault();" class="copy-button"
           data-clipboard-target="#shortcode_{{$item->id}}">
            <i class="fa fa-clipboard"></i>
        </a>
    </p>
    <p>
        <small class="text-muted">@lang('Corals::attributes.created_at'):</small>
        {{ $item->presenter()['created_at'] }}
    </p>
    <p>
        <small class="text-muted">@lang('Corals::attributes.updated_at'):</small>
        {{ $item->presenter()['updated_at'] }}
    </p>
    <p>
        <small class="text-muted">@lang('Subscriptions::attributes.product.description'):</small>
        <br/>{{ $item->description }}
    </p>
@endcomponent