@extends('layouts.master')

@section('editable_content')
    <div class="blog-post-hero" style="background-image: url({{ $featured_image }})">
        <div class="container">
            <h1 class="animated customFadeInUp">
                {{ $item->title }}
            </h1>
        </div>
    </div>
    <div class="blog-posts blog-post-wrapper">
        <div class="container">
            <div class="row">
                <div class="{{ $blog->template != 'full'?'col-md-9':'col-md-12' }} {{ $blog->template =='left'?'order-2':'' }}">
                    <div class="blog-post-header">
                        <div class="blog-post-author">
                            <img src="{{ $item->author->picture_thumb }}" class="avatar">
                           {{ trans('corals-express::labels.show_author',['name' => $item->author->name]) }}
                        </div>
                        <div class="blog-post-date">
                            @lang('corals-express::labels.date')<span>{{ format_date($item->published_at) }}</span>
                        </div>
                    </div>
                    <div class="content">
                        {!! $item->rendered !!}
                    </div>

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
                @if(in_array($blog->template,['left','right']))
                    <div class="{{ $blog->template =='right'? 'col-md-3':'order-1 col-md-3' }} sidebar">
                        @include('partials.blog_sidebar')
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop