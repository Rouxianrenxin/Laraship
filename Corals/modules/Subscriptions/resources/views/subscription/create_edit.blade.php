@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('subscription_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                <p class="bg-warning p-10">
                    @lang('Subscriptions::labels.subscription.avoid_data_inconsistency')
                </p>
                {!! CoralsForm::openForm($subscription) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('subscription_reference','Subscriptions::attributes.subscription.sub_reference',true) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true,get_array_key_translation(config('subscriptions.models.subscription.statuses')) ) !!}
                        {!! CoralsForm::select('plan_id','Subscriptions::attributes.subscription.plan_id', \Corals\Modules\Subscriptions\Facades\Products::getPlansList(), true, null, $subscription->exists?[]:[]) !!}
                        {!! CoralsForm::select('gateway', 'Subscriptions::attributes.subscription.gateway', \Payments::getAvailableGateways() , true, null, $subscription->exists?[]:[]) !!}
                        {!! CoralsForm::select('user_id','Subscriptions::attributes.subscription.user_id', [], false, null,
                                   ['class'=>'select2-ajax','data'=>[
                                   'model'=>\Corals\User\Models\User::class,
                                   'columns'=> json_encode(['name','last_name', 'email']),
                                   'selected'=>json_encode($subscription->user_id?[$subscription->user_id]:[]),
                                   'where'=>json_encode([]),
                                   ]],'select2') !!}
                        {!! CoralsForm::date('ends_at','Subscriptions::attributes.subscription.ends_at', false, $subscription->ends_at, ['help_text'=>""]) !!}
                        {!! CoralsForm::date('trial_ends_at','Subscriptions::attributes.subscription.trial_ends_at', false, $subscription->trial_ends_at, ['help_text'=>""]) !!}
                        {!! CoralsForm::date('next_billing_at','Subscriptions::attributes.subscription.next_billing_at', false, $subscription->next_billing_at, ['help_text'=>""]) !!}

                    </div>


                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>@lang('Corals::labels.address_label.bill_address')</h4>
                                <hr>
                                @include('components.address',['key'=>'billing_address', 'object'=> $subscription->billing_address,'type'=>'billing','container'=>'col-md-12'])

                            </div>
                            <div class="col-md-12">
                                <h4>@lang('Corals::labels.address_label.shipping_title')</h4>
                                <hr>
                                @include('components.address',['key'=>'shipping_address', 'object'=> $subscription->shipping_address,'type'=>'billing','container'=>'col-md-12'])

                            </div>
                        </div>

                    </div>

                </div>
                {!! CoralsForm::customFields($subscription,'col-md-6') !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($subscription) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection