@extends('layouts.master')

@section('editable_content')
    <div class="container padding-bottom-3x padding-top-3x mb-2">
        <div class="row">
            <!-- Content-->
            <div class="{{ !in_array($blog->template, ['right', 'left'])?'col-lg-12':'col-lg-9' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                <!-- Post Meta-->
                <ul class="post-meta mb-4">
                    <li><i class="icon-clock"></i><a href="#">{{ format_date($item->published_at) }}</a></li>
                    <li><i class="icon-user"></i><a
                                href="#">{!! trans('corals-ecommerce-ultimate::labels.post.show_author', ['name' => $item->author->name])  !!}</a>
                    </li>
                    <li>
                        @if(count($activeTags = $item->post->activeTags))
                            <div class="meta-link">
                                @foreach($activeTags as $tag)
                                    <a href="{{ url('tag/'.$tag->slug) }}">{{ $tag->name }}</a>,&nbsp;
                                @endforeach
                            </div>
                        @endif
                    </li>
                    <li>
                        <i class="icon-tag"></i>
                        @foreach($item->post->activeCategories as $category)
                            <a href="{{ url('category/'.$category->slug) }}">
                                &nbsp;{{ $category->name }}
                            </a>,&nbsp;
                        @endforeach
                    </li>
                </ul>
                <!-- Gallery-->
                <div class="gallery-wrapper">
                    <div class="gallery-item">
                        @if($featured_image) <a href="{{ url($item->slug) }}" data-size="1000x353"><img
                                    src="{{ $featured_image }}" alt="Post"> </a> @endif <span class="caption">Blog single post caption 1</span>
                    </div>
                </div>

                <div>
                    {!! $item->rendered !!}
                </div>
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