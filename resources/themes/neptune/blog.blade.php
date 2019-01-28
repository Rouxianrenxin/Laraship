@extends('layouts.master')
@section('editable_content')
    @include('partials.page_header', ['item'=>$blog])
    {!! $blog->rendered !!}
    <!-- ******Blog list Section****** -->
    <section id="blog-list" class="blog-list section">
        <div class="container">
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
                <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'order-2':'' }}">
                    @forelse($posts as $post)
                        <article class="item">
                            <div class="row">
                                <h3 class="post-title col-lg-10 col-md-9 col-12 ml-md-auto ">
                                    <a href="{{ url($post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <div class="w-100"></div>
                                <div class="meta col-lg-2 col-md-3 col-12 text-right">
                                    <ul class="meta-list list-unstyled">
                                        <li class="post-time post_date date updated">
                                            <span class="date">{{ $post->published_at->format('d') }}</span>
                                            <span class="month">{{ $post->published_at->format('M') }}</span>
                                        </li>
                                        <li class="post-author">{{ $post->author->name }}</li>
                                    </ul><!--//meta-list-->
                                </div><!--//meta-list-->
                                <div class="content-wrapper col-lg-10 col-md-9 col-12">
                                    @if($post->featured_image)
                                        <figure class="figure">
                                            <a href="{{ url($post->slug) }}">
                                                <img class="img-fluid" src="{{ $post->featured_image }}"
                                                     alt="">
                                            </a>
                                        </figure>
                                    @endif
                                    <div class="content">
                                        <div class="desc">
                                            <p>
                                                {{ str_limit(strip_tags($post->rendered ),250) }}
                                            </p>
                                            <a class="read-more" href="{{ url($post->slug) }}">
                                                @lang('corals-neptune::labels.read_more')
                                            </a>
                                        </div><!--//desc-->
                                    </div><!--//content-->
                                </div><!--//content-wrapper-->
                            </div><!--//row-->
                        </article><!--//item-->
                    @empty
                        <div class="alert alert-warning">
                            <h4>@lang('corals-neptune::labels.no_post_found')</h4>
                        </div>
                    @endforelse
                    <article class="item">
                        <div class="row">
                            {{ $posts->links('partials.paginator') }}
                        </div>
                    </article>
                </div>
                @if(in_array($blog->template,['left','right']))
                    <div class="{{ $blog->template =='right'? 'col-md-4':'order-1 col-md-4' }} blog-sidebar ml-md-auto">
                        @include('partials.blog_sidebar')
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection