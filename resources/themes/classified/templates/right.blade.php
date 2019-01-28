@extends('layouts.theme')

@section('hero_area')
    @include('partials.page_header')
@endsection

@section('editable_content')
    <div id="content" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-xs-12">
                    {!! $item->rendered !!}
                </div>
                <aside id="sidebar" class="col-lg-4 col-md-12 col-xs-12 right-sidebar">
                    @include('partials.page_sidebar')
                </aside>
            </div>
        </div>
    </div>
@endsection