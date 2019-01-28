<div class="row">
    <div class="col-md-12">
        {!! CoralsForm::select('subscription_plans[]','Subscriptions::attributes.subscription.plans', [], false, null,
        ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
        'model'=>\Corals\Modules\Subscriptions\Models\Plan::class,
        'columns'=> json_encode(['name']),
        'selected'=>json_encode($mix->subscribable_plans->pluck('id')->toArray()),
        'where'=>json_encode([['field'=>'status','operation'=>'=','value'=>'active']]),
        ]],'select2') !!}
    </div>
</div>