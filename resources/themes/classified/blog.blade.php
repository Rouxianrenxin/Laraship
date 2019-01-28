@extends('layouts.theme')

@section('hero_area')
    @include('partials.page_header', ['item'=>$blog])
@endsection

@section('editable_content')
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12">
                {!! $blog->rendered !!}
            </div>
        </div>
        @isset($title)
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left my-3">
                        <p>{{ $title }}</p>
                    </div>
                </div>
            </div>
        @endisset
    </div>

    <div class="container">
        <div class="row">
            <div class="{{ !in_array($blog->template, ['right', 'left'])?'col-lg-12':'col-lg-8 col-md-12 col-xs-12' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                @forelse($posts as $post)
                    <div class="blog-post">
                        @if($post->featured_image)
                            <div class="post-thumb">
                                <a href="{{ url($post->slug) }}"><img class="img-fluid"
                                                                      src="{{ $post->featured_image }}" alt=""></a>
                                <div class="hover-wrap"></div>
                            </div>
                        @endif
                        <div class="post-content">
                            <ul class="list-inline cat-meta">
                                @foreach($post->activeCategories as $category)
                                    <li class="tr-cats">
                                        <a href="{{ url('category/'.$category->slug) }}"><i
                                                    class="fa fa-folder-open"></i> {{ $category->name }}</a>
                                    </li>
                                @endforeach
                                @if(count($activeTags = $post->activeTags))
                                    @foreach($activeTags as $tag)
                                        <li class="tr-cats">
                                            <a href="{{ url('tag/'.$tag->slug) }}"><i
                                                        class="fa fa-tag"></i> {{ $tag->name }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <h2 class="post-title"><a href="{{ url($post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            <div class="meta">
                                    <span class="meta-part"><a href="#"><i
                                                    class="lni-user"></i> {{ $post->author->name }}</a></span>
                                <span class="meta-part"><a href="#"><i
                                                class="lni-alarm-clock"></i> {{ format_date($post->published_at) }}</a></span>
                            </div>
                            <div class="entry-summary">
                                <p>{{ str_limit(strip_tags($post->rendered ),250) }}</p>
                            </div>
                            <a href="{{ url($post->slug) }}"
                               class="btn btn-common btn-rm">@lang('corals-classified-master::labels.blog.read_more')</a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        <h6>@lang('corals-classified-master::labels.blog.no_posts_found')</h6>
                    </div>
                @endforelse
                {{ $posts->links('partials.paginator') }}
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