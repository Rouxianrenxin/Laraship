@extends('layouts.theme')

@section('hero_area')
    @include('partials.page_header')
@endsection

@section('editable_content')
    <div class="container">
        <div class="row">
            <div class="{{ !in_array($blog->template, ['right', 'left'])?'col-lg-12':'col-lg-8 col-md-12 col-xs-12' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                <div class="blog-post single-post">
                    @if($item->post->featured_image)
                        <div class="post-thumb">
                            <img class="img-fluid" src="{{ $item->post->featured_image }}" alt="">
                            <div class="hover-wrap"></div>
                        </div>
                    @endif
                    <div class="post-content">
                        <ul class="list-inline cat-meta">
                            @foreach($item->post->activeCategories as $category)
                                <li class="tr-cats">
                                    <a href="{{ url('category/'.$category->slug) }}"><i
                                                class="fa fa-folder-open"></i> {{ $category->name }}</a>
                                </li>
                            @endforeach
                            @if(count($activeTags = $item->post->activeTags))
                                @foreach($activeTags as $tag)
                                    <li class="tr-cats">
                                        <a href="{{ url('tag/'.$tag->slug) }}"><i
                                                    class="fa fa-tag"></i> {{ $tag->name }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <h2 class="post-title">{{ $item->post->title }}</h2>
                        <div class="meta">
                                    <span class="meta-part"><a href="#"><i
                                                    class="lni-user"></i> {{ $item->post->author->name }}</a></span>
                            <span class="meta-part"><a href="#"><i
                                            class="lni-alarm-clock"></i> {{ format_date($item->post->published_at) }}</a></span>
                        </div>
                        <div class="entry-summary">
                            {!! $item->post->rendered !!}
                        </div>
                    </div>
                </div>
            </div>
            @if(in_array($blog->template, ['right', 'left']))
                <aside id="sidebar"
                       class="col-lg-4 col-md-12 col-xs-12 right-sidebar {{ $blog->template =='left' ? 'order-lg-1':'' }}">
                    @include('partials.blog_sidebar')
                </aside>
            @endif
        </div>
    </div>
@endsection