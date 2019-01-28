@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('plan_create_edit',$product) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($plan) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('name','Subscriptions::attributes.plan.name',true,$plan->name,['help_text'=>'Subscriptions::attributes.plan.name_help']) !!}
                        {!! CoralsForm::text('code','Subscriptions::attributes.plan.code',true, $plan->code,
                        array_merge(['help_text'=>'Subscriptions::attributes.plan.code_help'],
                        $plan->exists?['readonly']:[])) !!}

                        @if(!$plan->exists)
                            {!! CoralsForm::checkbox('create_gateway_plan', 'Subscriptions::attributes.plan.create_gateway_plan') !!}
                        @endif

                        <fieldset>
                            <legend>@lang('Subscriptions::labels.plan.bill')</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! CoralsForm::number('price','Subscriptions::attributes.plan.price',true,$plan->exists?$plan->price:0,
                                    array_merge(['help_text'=>'Subscriptions::attributes.plan.price_help','right_addon'=>'<i class="'.$plan->currency_icon.'"></i>',
                                    'step'=>0.01,'min'=>0,'max'=>99999999],$plan->exists?['readonly']:[])) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! CoralsForm::number('bill_frequency','Subscriptions::attributes.plan.bill_frequency',true,$plan->exists?$plan->bill_frequency:1,
                                    array_merge(['step'=>1,'min'=>1,'max'=>999999],$plan->exists?['readonly']:[])) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! CoralsForm::select('bill_cycle', 'Subscriptions::attributes.plan.bill_cycle_every', trans('Subscriptions::attributes.plan.every_options'),true,$plan->bill_cycle,$plan->exists?['readonly']:[]) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p>@lang('Subscriptions::labels.plan.bill_cycle')</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! CoralsForm::number('trial_period','Subscriptions::attributes.plan.trial_period',false,$plan->exists?$plan->trial_period:0,
                                    ['help_text'=>'Subscriptions::attributes.plan.period_help',
                                    'step'=>1,'min'=>0,'max'=>999999]) !!}
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::textarea('description','Subscriptions::attributes.plan.description',true) !!}
                        <div class="row">
                            <div class="col-md-6">
                                {!! CoralsForm::number('display_order','Subscriptions::attributes.plan.display_order',false,$plan->exists?$plan->display_order:0,['step'=>1,'min'=>0,'max'=>999999]) !!}
                            </div>
                        </div>
                        {!! CoralsForm::checkbox('recommended', 'Subscriptions::attributes.plan.recommended',$plan->recommended) !!}
                        {!! CoralsForm::checkbox('free_plan', 'Subscriptions::attributes.plan.this_free_plan',$plan->free_plan,1,$plan->exists?['disabled']:[]) !!}
                        {!! CoralsForm::checkbox('is_visible', 'Subscriptions::attributes.plan.is_visible',$plan->exists?$plan->is_visible:true,1,
                        ['help_text'=>'Subscriptions::attributes.plan.visible_help']) !!}
                    </div>
                    <div class="col-md-4">
                        @forelse($product->features as $feature)
                            @php
                                $plan_feature =  $plan->features()->where('feature_id',$feature->id)->first()?: null;
                            @endphp
                            @if($feature->type == 'quantity')
                                {!! CoralsForm::number('features['.$feature->id.'][value]',$feature->name.' Amount',true,$plan_feature ? $plan_feature->pivot->value:null,['step'=>1,'min'=>0,'max'=>999999]) !!}
                            @elseif ($feature->type == 'boolean')
                                {!! CoralsForm::checkbox('features['.$feature->id.'][value]', $feature->name.' Included ',$plan_feature ? $plan_feature->pivot->value:false) !!}
                            @elseif ($feature->type == 'text')
                                {!! CoralsForm::text('features['.$feature->id.'][value]',$feature->name.' Text',true, $plan_feature ? $plan_feature->pivot->value:null) !!}
                            @endif
                        @empty
                            <strong class="text-danger">
                                {{trans('Subscriptions::labels.plan.product_name_does_net_feature',['name' => $product->name])}}
                                <br/>
                                <br/>
                                {!! CoralsForm::link((url(route(config('subscriptions.models.feature.resource_route'), ['product' => $product->hashed_id])).'/create'),
                                trans('Subscriptions::labels.plan.add_feature',['name' => $product->name]),['class'=>'btn btn-success']) !!}
                            </strong>
                        @endforelse
                    </div>
                </div>
                {!! CoralsForm::customFields($plan) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($plan) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection