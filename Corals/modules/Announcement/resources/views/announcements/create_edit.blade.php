@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('announcement_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($announcement,['files'=>true]) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('title','Announcement::attributes.announcement.title',true) !!}
                        {!! CoralsForm::date('starts_at','Announcement::attributes.announcement.starts_at', true, $announcement->starts_at) !!}
                        {!! CoralsForm::date('ends_at','Announcement::attributes.announcement.ends_at', true, $announcement->ends_at) !!}

                        {!! CoralsForm::text('show_in_url','Announcement::attributes.announcement.show_in_url',false,null,[
                            'help_text'=>'Announcement::attributes.announcement.show_in_url_help'
                        ]) !!}
                        {!! CoralsForm::checkbox('show_immediately', 'Announcement::attributes.announcement.show_immediately',$announcement->show_immediately) !!}
                        {!! CoralsForm::checkbox('is_public', 'Announcement::attributes.announcement.is_public',$announcement->is_public) !!}
                        {!! CoralsForm::select('roles[]','Announcement::attributes.announcement.roles', \Roles::getRolesList(), false, null, ['multiple'=>true], 'select2') !!}
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                {!! CoralsForm::file('image', 'Announcement::attributes.announcement.image') !!}
                            </div>
                            <div class="col-md-6">
                                @if($announcement->image)
                                    <img src="{{ $announcement->image }}" class="img-fluid w-50"
                                         style="max-width: 50%;"/>
                                @endif
                            </div>
                        </div>
                        {!! CoralsForm::textarea('content','Announcement::attributes.announcement.content', true, null, ['class'=>'ckeditor']) !!}
                        {!! CoralsForm::text('link','Announcement::attributes.announcement.link') !!}
                        {!! CoralsForm::text('link_title','Announcement::attributes.announcement.link_title') !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($announcement) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($announcement) !!}
            @endcomponent
        </div>
    </div>
@endsection
