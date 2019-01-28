@if($user->hasPermissionTo('Subscriptions::subscriptions.subscribe'))
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active nav-item">
                    <a href="#subscriptions" data-toggle="tab" class="active nav-link">
                        <i class="fa fa-diamond"></i> @lang('Subscriptions::labels.partial.subscription')
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active " id="subscriptions">
                    @component('components.box')

                        <div class="row">
                            <div class="col-md-4 text-center hidden-xs">
                                <img class="site_logo img-responsive m-t-20"
                                     style="max-width: 90%; margin: 0 auto;"
                                     src="{{ \Settings::get('site_logo') }}">

                                <i class="fa fa-diamond m-t-20 m-b-20"
                                   style="color:#7777770f; font-size: 10em;"></i>
                            </div>
                            <div class="col-md-8">
                                <h4>@lang('Subscriptions::labels.partial.subscription'):</h4>
                                <ul class="list-unstyled">
                                    @forelse($user->subscriptions as $subscription)
                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>{{ $subscription->plan->name }}</strong>
                                                    <br/>
                                                    <small>@lang('Subscriptions::attributes.subscription.description'):
                                                    </small>
                                                    <br/> {{ $subscription->plan->description }}
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                        <small>@lang('Corals::attributes.status_options.active'):
                                                        </small>
                                                        <b>{{ $subscription->active()?'Yes':'No' }}</b>
                                                    </p>
                                                    <p>
                                                        <small>@lang('Subscriptions::attributes.subscription.on_trial'):
                                                        </small>
                                                        <b>{{ $subscription->onTrial()?'Yes':'No' }}</b>
                                                    </p>
                                                    <p>
                                                        <small>@lang('Subscriptions::attributes.subscription.grace_period')
                                                            :
                                                        </small>
                                                        <b>{{ $subscription->onGracePeriod()?'Yes':'No' }}</b>
                                                    </p>
                                                    <p>
                                                        <small>@lang('Subscriptions::attributes.subscription.ends_at'):
                                                        </small>
                                                        <b>{{ $subscription->ends_at ?format_date($subscription->ends_at):'-' }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                            <hr/>
                                        </li>
                                    @empty
                                        <li>
                                            <p>@lang('Subscriptions::labels.partial.not_subscribed')</p>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endcomponent
                </div>
            </div>
            <!-- /.tab-pane -->
        </div>
@endif