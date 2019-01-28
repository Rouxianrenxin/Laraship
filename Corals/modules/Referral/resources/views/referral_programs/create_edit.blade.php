@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('referral_program_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    {!! CoralsForm::openForm($referral_program) !!}

    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name','ReferralProgram::attributes.referral_program.name',true) !!}
                        {!! CoralsForm::text('title','ReferralProgram::attributes.referral_program.title',true) !!}
                        {!! CoralsForm::text('uri','ReferralProgram::attributes.referral_program.uri',true,$referral_program->uri, ['help_text'=>'ReferralProgram::attributes.referral_program.uri_help']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('referral_action','Corals::labels.action', \Corals\Modules\Referral\Facades\Referral::getActions(),false,null, [], 'select2') !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('description','ReferralProgram::attributes.referral_program.description',true, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($referral_program, 'col-md-6') !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent

        </div>
        <div class="col-md-4">
            @component('components.box')
                <div id="action_view" style="display: none">
                </div>
            @endcomponent
        </div>
    </div>
    {!! CoralsForm::closeForm($referral_program) !!}

@endsection

@section('js')
    @parent
    <script type="text/javascript">
        @if($referral_program->exists)
        $(document).ready(function () {
            $('#referral_action').trigger('change');
        });
        @endif

        $(document).on('change', '#referral_action', function () {
            var $ele = $(this);

            if ($ele.val()) {
                var url = '{{ url("referral/referral-programs/get-action-view") }}' + "/" + $ele.val() + "/edit/" + "{{$referral_program->hashed_id}}";

                $.get(url).done(function (html) {
                    if (html) {
                        $('#action_view').empty();
                        $('#action_view').html(html);
                        $('#action_view').show();

                        initThemeElements();
                    } else {
                        $('#action_view').empty();
                        $('#action_view').hide();

                    }


                });
            } else {
                themeNotify({
                    level: 'error',
                    message: 'Select Action'
                })
            }
        });


    </script>
@endsection