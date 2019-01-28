@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header',['content'=>$blog->rendered])
    <div class="container">
        <div class="space-90"></div>
        @isset($title)
            <div class="text-left">
                <p>{{ $title }}</p>
                <hr/>
            </div>
        @endisset
        <div class="row">
            <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'order-2':'' }}">
                @forelse($posts as $post)
                    <div class="post margin-b-40">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" alt="" class="img-fluid">
                        @endif
                        <div class="blog-desc">
                            <div class="post-meta margin-b-10">
                                <span>{{ format_date($post->published_at) }} By <b>{{ $post->author->name }}</b></span>
                            </div>
                            <h4><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h4>
                            <p>
                                {{ str_limit(strip_tags($post->rendered ),250) }}
                            </p>
                            @foreach($post->activeCategories as $category)
                                <a href="{{ url('category/'.$category->slug) }}"><span
                                            class="badge badge-success"><i
                                                class="ion-android-folder-open"></i> {{ $category->name }} </span></a>
                            @endforeach
                            @foreach($post->activeTags as $tag)
                                <a href="{{ url('tag/'.$tag->slug) }}"><span class="badge badge-pill badge-primary"><i
                                                class="ion-ios-pricetag"></i> {{ $tag->name }} </span></a>&nbsp;
                            @endforeach
                            <div class="text-right">
                                <a href="{{ url($post->slug) }}"> @lang('corals-saas::labels.continue_read')</a>
                            </div>
                        </div>
                    </div><!--end post-->
                @empty
                    <div class="alert alert-warning">
                        <h4>@lang('corals-saas::labels.no_post_found')</h4>
                    </div>
                @endforelse
                <div class="post margin-b-40">
                    {{ $posts->links('partials.paginator') }}
                </div>
            </div>
            @if(in_array($blog->template,['left','right']))
                <div class="{{ $blog->template =='right'? 'col-md-4':'order-1 col-md-4' }}">
                    @include('partials.blog_sidebar')
                </div>
            @endif
        </div>
    </div>
    <div class="space-90"></div>
@endsection