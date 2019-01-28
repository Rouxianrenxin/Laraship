@isset($product)
    <div class="row">
        @foreach($product->activePlans as $plan)
            <div class="col-lg-3">
                <div class="card price-box">
                    <div class="head">
                        <div class="plan">
                            @if($plan->free_plan)
                                <h1>{{  \Payments::currency(0.00 ) }}</h1>
                            @else
                                <span class="plan-name">{{ $plan->name }}</span>
                                <div class="price">
                                    <span class="amt">{{  \Payments::currency($plan->price) }}
                                        <small class="font18 text-muted"> / {!! $plan->cycle_caption  !!}</small></span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="body">
                        <ul class="price-box-list">
                            @foreach($product->activeFeatures as $feature)
                                @if($plan_feature = $plan->features()->where('feature_id',$feature->id)->first())
                                    <li>
                                        @if($feature->type=="boolean")
                                            @if($plan_feature->pivot->value)
                                                <i class="fa fa-check"></i>
                                            @endif
                                        @else
                                            {{$plan_feature->pivot->value }} {{$feature->unit }}
                                        @endif
                                        {{ $feature->caption }}
                                    </li>
                                @else
                                    <li>
                                        <i class="fa fa-times"></i>
                                        {{ $feature->caption }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <br><br>
                        <div class="price-footer">
                            @if(user() && user()->subscribed(null, $plan->id))
                                <button class="btn btn-secondary" disabled>
                                    Current Package
                                </button>
                                <br/>
                                {{ user()->currentSubscription(null, $plan->id)->ends_at?('ends at: '.format_date_time(user()->currentSubscription(null, $plan->id)->ends_at)):'' }}
                            @else
                                <a href="{{ url('subscriptions/checkout/'.$plan->hashed_id) }}"
                                   class="btn btn-primary">@lang('corals-compo::labels.pricing.subscribe_now')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-center text-danger"><strong>@lang('corals-compo::labels.pricing.product_not_found')</strong></p>
@endisset