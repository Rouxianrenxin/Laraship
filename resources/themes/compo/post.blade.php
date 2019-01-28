@extends('layouts.master')

@section('editable_content')
    <div id="blog" class="container m-t-30" style="padding-bottom: 100px">
        <div class="blog">
            <div class="row">
                <div class="{{ $blog->template != 'full'?'col-md-8':'col-md-12' }} {{ $blog->template =='left'?'col-md-push-4':'' }}">
                    @if($featured_image)
                        <div class="text-center wow fadeIn" style="margin-bottom: 10px;">
                            <img src="{{ $featured_image }}" alt="{{ $item->title }}" width="100%"/>
                        </div>
                    @endif
                    <div class="blog-item">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2 text-center">
                                <div class="posted-on">
                                    <span class="date">{{$item->created_at->format('d')}}</span>
                                    <span class="month">{{$item->created_at->format('M')}}</span>
                                </div>
                                <div class="blog-meta text-muted">
                                   <a href=""> {{ $item->author->name }}</a>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-10 blog-content">
                                <h2>{{ $item->title }}</h2>
                                <div>
                                    {!! $item->rendered !!}
                                </div>
                                @foreach($item->post->activeCategories as $category)
                                    <a href="{{ url('category/'.$category->slug) }}"><span
                                                class="label label-success" style="padding: 7px;border-radius: 5px;"><i
                                                    class="fa fa-folder-open"></i> {{ $category->name }} </span></a>
                                    &nbsp;
                                @endforeach
                                @foreach($item->post->activeTags as $tag)
                                    <a href="{{ url('tag/'.$tag->slug) }}"><span class="label label-primary"><i
                                                    class="fa fa-tag"></i> {{ $tag->name }} </span></a>
                                    &nbsp;
                                @endforeach
                            </div>
                        </div>
                    </div><!--/.blog-item-->
                </div>
                @if($blog->template != 'full')
                    <aside class="{{ $blog->template =='right'? 'col-md-4':'col-md-pull-8 col-md-4' }}">
                        @include('partials.blog_sidebar')
                    </aside>
                @endif
            </div>
        </div>
    </div>
@stop