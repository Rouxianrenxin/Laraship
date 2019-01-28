<div>
    @if($edit_mode =="edit")
    {!! CoralsForm::number('options[rewards][registration]','ReferralProgram::attributes.referral_program.registration_award' ,true,$referral_program->options['rewards']['registration'] ?? 0,
['help_text'=>'Points',
'step'=>1,'min'=>0,'max'=>999999]) !!}
        @else
        <h5>{!! trans('ReferralProgram::labels.registration_award',['count' => ($referral_program->options['rewards']['registration']  ?? 0)]) !!}</h5>
    @endif
</div>












