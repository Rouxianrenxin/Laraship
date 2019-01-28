
<div class="panel-group" id="accordion">
    @foreach($action_parameters['products'] as $product)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$product->hashed_id}}">
                        {{$product->name}}</a>
                </h4>
            </div>
            <div id="collapse_{{$product->hashed_id}}" class="panel-collapse collapse @if($loop->first) in @endif">
                <div class="panel-body">
                        @foreach($product->plans as $plan)
                            @if($edit_mode =="edit")
                                {!! CoralsForm::number('options[rewards][subscription][plan_'.$plan->id.']',$plan->name ,false,$referral_program->options['rewards']['subscription']['plan_'.$plan->id] ?? 0,
                ['help_text'=>'Points',
                'step'=>1,'min'=>0,'max'=>999999]) !!}
@else

                                <li>{{$plan->name }} : {!! trans('ReferralProgram::labels.name_point',['name' => ($referral_program->options['rewards']['subscription']['plan_'.$plan->id]) ?? 0]) !!}</li>
                                @endif

                        @endforeach

                </div>
            </div>
        </div>
    @endforeach
</div>













