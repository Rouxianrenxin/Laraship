@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('widget_create_edit', $block) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! CoralsForm::openForm($widget) !!}
            @component('components.box')
                <div class="row">
                    <div class="col-md-8">
                        {!! CoralsForm::text('title','CMS::attributes.content.title',true) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::number('widget_width', 'CMS::attributes.widget.widget_width', true, $widget->widget_width, [
                            'help_text'=>'CMS::attributes.widget.widget_width_help','min' => 1, 'max' => 12]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','CMS::attributes.content.content',true, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('CMS::attributes.widget.status_options')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! CoralsForm::customFields($widget) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            {!! CoralsForm::closeForm($widget) !!}
        </div>
    </div>
@endsection