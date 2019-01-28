@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('discussion_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">
            {!! CoralsForm::link(url('messaging/discussions'),'Messaging::labels.discussion.inbox',['class'=>"btn btn-primary btn-block margin-bottom"]) !!}
            @include('Messaging::partials.messaging_sidebar')
        </div>
        <!-- /.col -->
        <div class="col-md-10">
            @component('components.box')
                @slot('box_title')
                    @lang('Messaging::labels.discussion.create_new_discussion')
                @endslot
                {!! CoralsForm::openForm($discussion) !!}

                @can('select_recipient', $discussion)
                    {!! CoralsForm::select(\Settings::get('messaging_is_multiple_participations')?'user_id[]':'user_id','Messaging::attributes.discussion.to', [], true, null,
                         array_merge(['class'=>'select2-ajax','data'=>[
                         'model'=>\Corals\User\Models\User::class,
                         'columns'=> json_encode(['name', 'email']),
                         'selected'=>json_encode($discussion->user_id ? [$discussion->user_id] :[]),
                         'where'=>json_encode([]),
                         ]],\Settings::get('messaging_is_multiple_participations') ? ['multiple'=>'multiple']:[]),'select2')
                    !!}
                @elseif(isset($user))
                    {!! CoralsForm::label('to','Messaging::attributes.discussion.to')!!}
                    <h5>{{ $user->full_name.'-'.$user->email }}</h5>
                    <br/>
                    <input type="hidden" name="user_id" value="{{ $discussion->user_id }}"/>
                @endcan
                {!! CoralsForm::text('subject','Messaging::attributes.discussion.subject',true,$discussion->subject) !!}
                {!! CoralsForm::textarea('body','Messaging::attributes.discussion.body',true, null, ['class'=>'ckeditor']) !!}

                {!! CoralsForm::customFields($discussion) !!}
                {!! CoralsForm::formButtons() !!}

                {!! CoralsForm::closeForm($discussion) !!}
            @endcomponent
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('js')
    <script>
        CKEDITOR.config.toolbarGroups = [
            {name: 'document', groups: ['mode', 'document', 'doctools']},
            {name: 'clipboard', groups: ['clipboard', 'undo']},
            {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
            {name: 'forms', groups: ['forms']},
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
            {name: 'links', groups: ['links']},
            '/',
            {name: 'insert', groups: ['insert']},
            {name: 'styles', groups: ['styles']},
            {name: 'colors', groups: ['colors']},
            {name: 'tools', groups: ['tools']},
            {name: 'others', groups: ['others']},
            {name: 'about', groups: ['about']}
        ];
        CKEDITOR.config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Language,Anchor,Image,Flash,Iframe,Maximize,About';
    </script>
@endsection