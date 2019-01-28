@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header', ['item'=>$blog, 'content'=> (empty($blog->rendered)?('<h1>'.$blog->title.'</h1>'):$blog->rendered).(isset($title)?('<br/>'.$title):'')])

    <div class="container padding-bottom-3x padding-top-3x mb-1">
        <div class="row">
            <div class="{{ !in_array($blog->template, ['right', 'left'])?'col-lg-12':'col-lg-9' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                <div class="isotope-grid cols-2 mb-4">
                    <div class="gutter-sizer"></div>
                    <div class="grid-sizer"></div>
                    <!-- Post-->
                    @forelse($posts as $post)
                        <div class="grid-item">
                            <div class="blog-post">
                                @if($post->featured_image)
                                    <a class="post-thumb" href="{{ url($post->slug) }}">
                                        <img src="{{ $post->featured_image }}"
                                             alt="Post">
                                    </a>
                                @endif
                                <div class="post-body">
                                    <ul class="post-meta">
                                        <li><i class="icon-clock"></i><a
                                                    href="#">{{ format_date($post->published_at) }}</a></li>
                                        <li><i class="icon-user"></i><a href="#">{{ $post->author->name }}</a></li>
                                        @if(count($activeTags = $post->activeTags))
                                            <li>
                                                <i class="icon-tag"></i>
                                                @foreach($activeTags as $tag)
                                                    <a href="{{ url('tag/'.$tag->slug) }}">&nbsp;{{ $tag->name }}</a>,
                                                @endforeach
                                            </li>
                                        @endif
                                        <li>
                                            <i class="icon-folder"></i>
                                            @foreach($post->activeCategories as $category)
                                                <a href="{{ url('category/'.$category->slug) }}">
                                                    &nbsp;{{ $category->name }}
                                                </a>,
                                            @endforeach
                                        </li>
                                    </ul>
                                    <h3 class="post-title"><a href="{{ url($post->slug) }}">
                                            {{ $post->title }}</a></h3>
                                    <p>
                                        {{ str_limit(strip_tags($post->rendered ),250) }}
                                        <a href='{{ url($post->slug) }}'
                                           class='text-medium'>@lang('corals-ecommerce-ultimate::labels.blog.read_more')</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">
                            <h4>@lang('corals-ecommerce-ultimate::labels.blog.no_posts_found')</h4>
                        </div>
                    @endforelse

                </div>
                <!-- Pagination-->
                {{ $posts->links('partials.paginator') }}
            </div>
            <!-- Sidebar          -->
            @if(in_array($blog->template, ['right', 'left']))
                <div class="col-lg-3 {{ $blog->template =='left' ? 'order-lg-1':'' }}">
                    @include('partials.blog_sidebar')
                </div>
            @endif
        </div>
    </div>
@stop