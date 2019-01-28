@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('post_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            {!! CoralsForm::openForm($post, ['files' => true]) !!}
            {!! Form::model($post, ['url' => url($resource_url.'/'.$post->hashed_id),'method'=>$post->exists?'PUT':'POST','files'=>true,'class'=>'ajax-form']) !!}
            @component('components.box')
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('title','CMS::attributes.content.title',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::text('slug','CMS::attributes.content.slug',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::select('categories[]','CMS::attributes.content.categories', \CMS::getCategoriesList(false, null, null, 'post'),true,null,['multiple'=>true], 'select2') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','CMS::attributes.content.content',true, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_keywords','CMS::attributes.content.meta_keywords',false,$post->meta_keywords,['rows'=>4]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_description','CMS::attributes.content.meta_description',false,$post->meta_description,['rows'=>4]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                {!! CoralsForm::select('tags[]','CMS::attributes.content.tags', \CMS::getTagsList(),false,null,['class'=>'tags','multiple'=>true], 'select2') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('published', 'CMS::attributes.content.published',$post->published) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('private', 'CMS::attributes.content.private',$post->private, 1,
                                ['help_text'=>'CMS::attributes.content.private_help']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('internal', 'CMS::attributes.content.internal', $post->internal, 1,
                                ['help_text'=>'CMS::attributes.content.internal_help']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" class="img-responsive" style="max-width: 100%;"
                                 alt="Featured Image"/>
                            <br/>
                            {!! CoralsForm::checkbox('clear', 'CMS::attributes.content.clear') !!}
                        @endif
                        {!! CoralsForm::file('featured_image', 'CMS::attributes.content.featured_image') !!}
                        -- OR --
                        <br/>
                        <br/>
                        {!! CoralsForm::text('featured_image_link','CMS::attributes.content.featured_image_link') !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($post) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            {!! CoralsForm::closeForm($post) !!}
        </div>
    </div>
@endsection