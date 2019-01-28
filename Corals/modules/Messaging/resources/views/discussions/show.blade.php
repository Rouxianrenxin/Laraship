@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('discussion_show') }}
        @endslot
    @endcomponent
@endsection

@section('css')
    <style>
        .box-comments .even {
            background: #e8e8e8;
        }

        .media {
            padding: 10px !important;
        }

        .media .media-left {
            margin: 0 10px;
        }
    </style>
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
                    {!! $discussion->subject !!}
                @endslot
                @slot('box_actions')
                    @if($discussion->getUserParticipation()->status != 'deleted')
                        {!! CoralsForm::openForm($discussion, ['url' => 'messaging/discussions/' . $discussion->hashed_id, 'method' => 'DELETE']) !!}

                        <button type="submit" class="btn btn-default"><i
                                    class="fa fa-trash-o"></i></button>
                        {!! CoralsForm::closeForm() !!}
                    @else
                        {!! CoralsForm::link(url('messaging/discussions/'. $discussion->hashed_id . '/markAsRead'),'<i class="fa fa-envelope-open"></i>', ['data' => ['action' => 'post', 'page_action' => 'site_reload'], 'class'=>"btn btn-default btn-sm"]) !!}
                    @endif
                @endslot

                <div class="mailbox-read-info">
                    <h5>@lang('Messaging::labels.discussion.creator') - {!! $discussion->present('creator') !!}
                        <span class="mailbox-read-time pull-right">{!! $discussion->present('created_at') !!}</span>
                    </h5>
                </div>

                <div class="mailbox-read-message">
                    <h5>@lang('Messaging::labels.participation.participation')</h5>
                    {!! $discussion->present('participations') !!}
                </div>
                <div class="box-comments m-t-30 m-b-30">
                    @php
                        $i = 1;
                        $class="";
                    @endphp
                    @if(count($discussion->messages))
                        @foreach($discussion->messages as $message)
                            @if($i % 2 == 0)
                                @php $class="even"; @endphp
                            @else
                                @php $class=""; @endphp
                            @endif
                            <div class="media {{ $class }}">
                                <div class="media-left media-middle">
                                    <a class="pull-left" href="#">
                                        <img class="media-object" width="30" height="30"
                                             src="{!! $message->author->picture_thumb !!}"
                                             alt="{!! $message->author->name !!}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{!! $message->present('author') !!}
                                        <span class="pull-right">

                                            <span class="mailbox-read-time">{!! $message->present('created_at') !!} </span>
                                            @if($message->canDeleteMessage($discussion->id) && ($message->author->id == user()->id))
                                                {!! CoralsForm::link(url('messaging/messages/'.$message->hashed_id),'<i class="fa fa-trash "></i>',['data' => ['action' => 'delete'], 'class'=>"m-l-10 text-red"]) !!}
                                            @endif
                                            </span>
                                    </h4>

                                    <div class="comment-body" id="comment-body-{{ $message->id }}">
                                        {!! $message->present('body') !!}
                                    </div>

                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    @endif
                </div>

                {!! CoralsForm::openForm(null, ['url' => 'messaging/messages', 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-12 m-b-10">
                        <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
                        {!! CoralsForm::textarea('body','Messaging::attributes.discussion.body',true, null, ['class'=>'ckeditor']) !!}
                    </div>

                    <div class="col-md-12 m-b-10">
                        <button type="submit" class="btn btn-default pull-right"><i
                                    class="fa fa-reply"></i> @lang('Messaging::attributes.discussion.reply')
                        </button>
                    </div>
                </div>
                {!! CoralsForm::closeForm() !!}

            @endcomponent
        </div>
        <!-- /.col -->
    </div>
@endsection


@section('js')
    <script>
        function appendMessageBody(response) {
            if (response.body && response.message_id) {
                $('#comment-body-' + response.message_id).html(response.body);
            }
        }

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

