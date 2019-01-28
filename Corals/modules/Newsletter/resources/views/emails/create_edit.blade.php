@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('email_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($email) !!}

                <div class="row">

                    <div class="col-md-6">
                        {!! CoralsForm::select('mail_lists[]', 'Newsletter::attributes.email.mail_lists', \Newsletter::getAllMailLists(), false, null,
                        ['multiple' => true, 'help_text' => 'Newsletter::attributes.email.mail_lists_help'], 'select2') !!}
                    </div>

                    <div class="col-md-6">
                        {!! CoralsForm::select('subscribers[]', 'Newsletter::attributes.email.subscribers', \Newsletter::getAllSubscribers(), false, null, ['multiple' => true], 'select2') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('subject','Newsletter::attributes.email.subject',true) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea("email_body", 'Newsletter::attributes.email.email_body', true, $email->email_body??'', ['class'=>'ckeditor']) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($email) !!}

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            {!! CoralsForm::button('Newsletter::labels.email.save_as_draft', ['class'=>'btn btn-success','name'=>'submit_type', 'value'=>'draft'], 'submit') !!}
                            {!! CoralsForm::button('Newsletter::labels.email.save_and_draft', ['class'=>'btn btn-primary','name'=>'submit_type', 'value'=>'send'], 'submit') !!}
                        </div>
                    </div>
                </div>
                {!! CoralsForm::closeForm($email) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection