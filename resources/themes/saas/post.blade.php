@extends('layouts.master')

@section('editable_content')
    <div class="space-70"></div>
    @include('partials.page_header',['content'=>''])
    <div class="container">
        <div class="space-90"></div>
        <div class="row">
            <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'order-2':'' }}">
                <div class="post">
                    <div class="blog-desc">
                        <div class="post-meta margin-b-10">
                            <span>{{ format_date($item->published_at) }} By <b>{{ $item->author->name }}</b></span>
                        </div>
                        <h2>{{ $item->title }}</h2>
                        {!! $item->rendered !!}
                        @foreach($item->post->activeCategories as $category)
                            <a href="{{ url('category/'.$category->slug) }}"><span
                                        class="badge badge-success"><i
                                            class="ion-android-folder-open"></i> {{ $category->name }} </span></a>
                        @endforeach
                        @foreach($item->post->activeTags as $tag)
                            <a href="{{ url('tag/'.$tag->slug) }}"><span class="badge badge-pill badge-primary"><i
                                            class="ion-ios-pricetag"></i> {{ $tag->name }} </span></a>&nbsp;
                        @endforeach
                    </div>
                </div><!--end post-->
                <div class="space-50"></div>
            </div>
            @if(in_array($blog->template,['left','right']))
                <div class="{{ $blog->template =='right'? 'col-md-4':'order-1 col-md-4' }}">
                    @include('partials.blog_sidebar')
                </div>
            @endif
        </div>
    </div>
@stop