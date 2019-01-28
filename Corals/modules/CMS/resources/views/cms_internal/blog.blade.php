@extends('layouts.master')

@section('title', $blog->title)

@section('content')
    @include('CMS::cms_internal.partials.page_header', ['content'=> $blog->rendered, 'item' => $blog])

    @isset($title)
        <div class="text-left">
            <p>{{ $title }}</p>
            <hr/>
        </div>
    @endisset

    <div class="row">
        <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'col-md-push-4':'' }}">
            @forelse($posts as $post)
                <div class="">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="" class="img-thumbnail">
                    @endif
                    <div class="m-t-20">
                        <div class="">
                            <span>{{ format_date($post->published_at) }} By <b>{{ $post->author->name }}</b></span>
                        </div>
                        <h4><a href="{{ url('cms/'.$post->slug) }}">{{ $post->title }}</a></h4>
                        <div>
                            {{ str_limit(strip_tags($post->rendered ),250) }}
                        </div>
                        <div>
                            @foreach($post->activeCategories as $category)
                                <a href="{{ url('cms/category/'.$category->slug) }}" class="m-r-5"><span
                                            class="label label-success"><i
                                                class="fa fa-folder-open-o"></i> {{ $category->name }} </span></a>
                            @endforeach
                            @foreach($post->activeTags as $tag)
                                <a href="{{ url('cms/tag/'.$tag->slug) }}" class="m-r-5"><span
                                            class="label label-primary"><i
                                                class="fa fa-tag"></i> {{ $tag->name }} </span></a>&nbsp;
                            @endforeach
                        </div>
                        <div class="text-right">
                            <a href="{{ url('cms/'.$post->slug) }}">@lang('CMS::labels.cms_internal.read_more')</a>
                        </div>
                        <hr/>
                    </div>
                </div><!--end post-->
            @empty
                <div class="alert alert-warning">
                    <h4>@lang('CMS::labels.cms_internal.no_posts_found')</h4>
                </div>
            @endforelse
            <div class="">
                {{ $posts->links() }}
            </div>
        </div>
        @if(in_array($blog->template,['left','right']))
            <div class="{{ $blog->template =='left'?'col-md-pull-8':'' }} col-md-4">
                @include('CMS::cms_internal.partials.blog_sidebar')
            </div>
        @endif
    </div>
@endsection