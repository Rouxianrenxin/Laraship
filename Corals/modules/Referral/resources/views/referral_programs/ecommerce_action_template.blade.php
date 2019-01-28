<div>
    @if($edit_mode =="edit")
        {!! CoralsForm::select('options[rewards][ecommerce][reward_per]','ReferralProgram::attributes.referral_program.ecommerce_reward_per' ,['sale'=>trans('ReferralProgram::attributes.referral_program.ecommerce_reward_per_sale'),'order_amount'=>trans('ReferralProgram::attributes.referral_program.ecommerce_reward_per_order_amount')],true,$referral_program->options['rewards']['ecommerce']['reward_per'] ?? 0,
    ['help_text'=>'']) !!}

        {!! CoralsForm::number('options[rewards][ecommerce][reward]','ReferralProgram::attributes.referral_program.ecommerce_award' ,true,$referral_program->options['rewards']['ecommerce']['reward'] ?? 0,
['help_text'=>'Points',
'step'=>1,'min'=>0,'max'=>999999]) !!}

    @else
        @if( $referral_program->options['rewards']['ecommerce']['reward_per'] == "sale")
            <h5>{!! trans('ReferralProgram::labels.ecommerce_reward_sale',['count' => $referral_program->options['rewards']['ecommerce']['reward']  ?? 0 ]) !!}</h5>
        @else
            <h5>{!! trans('ReferralProgram::labels.ecommerce_reward_order_amount',['count' => $referral_program->options['rewards']['ecommerce']['reward']  ?? 0 ]) !!}</h5>

        @endif
    @endif
</div>