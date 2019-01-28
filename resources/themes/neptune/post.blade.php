@extends('layouts.master')

@section('editable_content')
    <!-- ******Blog Post****** -->
    <div class="blog-post-wrapper container">
        <div class="row">
            <div class="blog-entry {{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'order-2':'' }}">
                <article class="post">
                    <h2 class="title">{{ $item->title }}</h2>
                    <div class="meta">
                        <ul class="meta-list list-inline">
                            <li class="list-inline-item post-time post_date date updated"><i class="fa fa-calendar"></i>
                                {{ format_date($item->published_at) }}
                            </li>
                            <li class="list-inline-item post-author"><i
                                        class="fa fa-user"></i> {{ $item->author->name }}</li>
                        </ul><!--//meta-list-->
                    </div><!--meta-->
                    <div class="content">
                        @if($featured_image)
                            <p class="post-figure">
                                <img class="img-fluid" src="{{ $featured_image }}" alt=""/>
                            </p><!--//post-figure-->
                        @endif
                        {!! $item->rendered !!}

                        @foreach($item->post->activeCategories as $category)
                            <a href="{{ url('category/'.$category->slug) }}"><span
                                        class="badge badge-success"><i
                                            class="fa fa-folder"></i> {{ $category->name }} </span></a>
                        @endforeach
                        @foreach($item->post->activeTags as $tag)
                            <a href="{{ url('tag/'.$tag->slug) }}"><span class="badge badge-pill badge-primary"><i
                                            class="fa fa-tag"></i> {{ $tag->name }} </span></a>&nbsp;
                        @endforeach
                    </div>
                </article><!--//post-->
            </div><!--//blog-entry-->
            @if(in_array($blog->template,['left','right']))
                <div class="{{ $blog->template =='right'? 'col-md-4':'order-1 col-md-4' }} blog-sidebar ml-md-auto">
                    @include('partials.blog_sidebar')
                </div>
            @endif
        </div><!--//row-->
    </div><!--//blog-->
@stop