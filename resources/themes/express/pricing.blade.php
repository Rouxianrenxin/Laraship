@isset($product)
    <div class="pricing-3-options-section">
        <div class="charts">
            <div class="row">
                @foreach($product->activePlans as $plan)
                    <div class="col-md-3">
                        <div class="chart {{ $plan->recommended?'featured':'' }}">
                            @if($plan->recommended)
                                <img src="{{ Theme::url('images/ribbon.png') }}" class="popular" alt="ribbon">
                            @endif
                            <div class="quantity">
                                @if($plan->free_plan)
                                    <span class="price">{{  \Payments::currency(0.00) }}</span>
                                @else
                                    <span class="price">
                                {{  \Payments::currency($plan->price) }}
                            </span>
                                    <br/>
                                    <span class="peroid">{!! $plan->cycle_caption  !!}</span>
                                @endif
                            </div>
                            <div class="plan-name">{{ $plan->name }}</div>
                            <div class="specs">
                                @foreach($product->activeFeatures as $feature)
                                    @if($plan_feature = $plan->features()->where('feature_id',$feature->id)->first())
                                        <div class="spec">
                                            @if($feature->type=="boolean")
                                                @if($plan_feature->pivot->value)
                                                    <i class="fa fa-check"></i>
                                                @endif
                                            @else
                                                {{$plan_feature->pivot->value }} {{$feature->unit }}
                                            @endif
                                            {{ $feature->caption }}
                                        </div>
                                    @else
                                        <div class="spec">
                                            <i class="fa fa-times"></i>
                                            {{ $feature->caption }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if(user() && user()->subscribed(null, $plan->id))
                                <a href="#"
                                   class="btn-signup button-clear">
                                    <span>@lang('corals-express::labels.current_package')</span>
                                </a>
                                <br/>
                                {{ user()->currentSubscription(null, $plan->id)->ends_at?('ends at: '.format_date_time(user()->currentSubscription(null, $plan->id)->ends_at)):'' }}
                            @else
                                <a class="btn-signup button-clear"
                                   href="{{ url('subscriptions/checkout/'.$plan->hashed_id) }}">
                                    <span>@lang('corals-express::labels.subscribe_now')</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <br/>
    </div>
@else
    <p class="text-center text-danger"><strong> @lang('corals-express::labels.product_cannot_found')</strong></p>
@endisset