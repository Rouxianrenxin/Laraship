@extends('layouts.master')

@section('editable_content')
    <section class="container">
        <div id="blog" class="container">
            {!! $blog->rendered !!}
        </div>
        @isset($title)
            <div class="text-left">
                <p>{{ $title }}</p>
                <hr/>
            </div>
        @endisset
        <div class="row">
            <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'order-md-2':'' }}">
                @forelse($posts as $post)
                    <div class="card blog-card mt-0">
                        <div class="card-body">
                            <div class="posted-on">
                                <span class="date">{{$post->created_at->format('d')}}</span>
                                <span class="month">{{$post->created_at->format('M')}}</span>
                            </div>
                            <div class="blog-media">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image }}" class="img-responsive" width="100%" alt="">
                                @endif
                            </div>
                            <div class="blog-meta text-muted">
                                By <a href=""> {{ $post->author->name }}</a>
                            </div>
                            <div class="blog-body">
                                <a href="{{ url($post->slug) }}" class="blog-title">
                                    <h3 class="heading">{{ $post->title }}</h3>
                                </a>
                                <p>
                                    {{ str_limit(strip_tags($post->rendered ),250) }}
                                </p>
                                <a href="{{ url($post->slug) }}" class="btn btn-primary btn-sm">@lang('corals-compo::labels.blog.read_more')</a>
                            </div>
                        </div>
                    </div><!--/.blog-item-->
                @empty
                    <div class="alert alert-warning">
                        <h4><strong> @lang('corals-compo::labels.blog.no_posts_found') </strong></h4>
                    </div>
                @endforelse
                {{ $posts->links('partials.paginator') }}
            </div><!--/.col-md-8-->
            @if(in_array($blog->template, ['right', 'left']))
                <aside class="{{ $blog->template =='right'? 'col-md-4':'order-md-1 col-md-4' }}">
                    @include('partials.blog_sidebar')
                </aside>
            @endif
        </div><!--/.row-->

    </section>
@endsection