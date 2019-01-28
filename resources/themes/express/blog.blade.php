@extends('layouts.master')

@section('editable_content')
    <div class="blog-posts">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $blog->rendered !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @isset($title)
                        <div class="text-left">
                            <p>{{ $title }}</p>
                            <hr/>
                        </div>
                    @endisset
                </div>
            </div>
            <div class="row">
                <div class="{{ $blog->template != 'full'?'col-md-9':'col-md-12' }} {{ $blog->template =='left'?'order-2':'' }}">
                    @forelse($posts as $post)
                        <div class="post">
                            @if($post->featured_image)
                                <a href="{{ url($post->slug) }}" class="pic">
                                    <img src="{{ $post->featured_image }}" alt="" class="img-fluid">
                                </a>
                            @endif

                            <div class="title">
                                <a href="{{ url($post->slug) }}">{{ $post->title }}</a>
                            </div>
                            <div class="author">
                                <img src="{{ $post->author->picture_thumb }}" class="avatar" alt="author">
                                {{ $post->author->name }}, {{ format_date($post->published_at) }}
                            </div>
                            <p class="intro">
                                {{ str_limit(strip_tags($post->rendered ),250) }}
                            </p>
                            <a href="{{ url($post->slug) }}" class="continue-reading">@lang('corals-express::labels.continue_reading')</a>
                        </div>
                    @empty
                        <div class="alert alert-warning">
                            <h4>@lang('corals-express::labels.no_post')</h4>
                        </div>
                    @endforelse
                    <div class="pages">
                        {{ $posts->links('partials.paginator') }}
                    </div>
                </div>
                @if(in_array($blog->template,['left','right']))
                    <div class="{{ $blog->template =='right'? 'col-md-3':'order-1 col-md-3' }} sidebar">
                        @include('partials.blog_sidebar')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection