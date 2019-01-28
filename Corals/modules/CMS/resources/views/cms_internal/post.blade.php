@extends('layouts.master')

@section('title', $item->title)

@section('content')
    @include('CMS::cms_internal.partials.page_header')
    
    <div class="row">
        <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'col-md-offset-4':'' }}">
            <div class="">
                <span>{{ format_date($item->published_at) }} By <b>{{ $item->author->name }}</b></span>
            </div>
            <h2>{{ $item->title }}</h2>
            {!! $item->rendered !!}
            <div>
                @foreach($item->post->activeCategories as $category)
                    <a href="{{ url('category/'.$category->slug) }}" class="m-r-5"><span
                                class="label label-success"><i
                                    class="fa fa-folder-open-o"></i> {{ $category->name }} </span></a>
                @endforeach
                @foreach($item->post->activeTags as $tag)
                    <a href="{{ url('tag/'.$tag->slug) }}" class="m-r-5"><span class="label label-primary"><i
                                    class="fa fa-tag"></i> {{ $tag->name }} </span></a>&nbsp;
                @endforeach
            </div>
        </div>
        @if(in_array($blog->template,['left','right']))
            <div class="{{ 'col-md-4' }}">
                @include('CMS::cms_internal.partials.blog_sidebar')
            </div>
        @endif
    </div>
@stop