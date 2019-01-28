@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header',['title'=>$item->title,'featured_image'=>null])
    <div class="container padding-bottom-3x mb-1">
        <div class="row {{ !in_array($blog->template, ['right', 'left'])?'justify-content-center':'' }}">
            <div class="{{ !in_array($blog->template, ['right', 'left'])?'col-lg-10':'col-xl-9 col-lg-8' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                <!-- Post-->
                <div class="single-post-meta">
                    <div class="column">
                        <div class="meta-link">{{trans('corals-ecommerce-basic::labels.post.show_author',['name' => $item->author->name])}}</div>
                        @if(count($activeTags = $item->post->activeTags))
                            <div class="meta-link">
                                @foreach($activeTags as $tag)
                                    <a href="{{ url('tag/'.$tag->slug) }}">{{ $tag->name }}</a>,&nbsp;
                                @endforeach
                            </div>
                        @endif
                        <div class="meta-link">
                            <span>@lang('corals-ecommerce-basic::labels.post.category')</span>
                            @foreach($item->post->activeCategories as $category)
                                <a href="{{ url('category/'.$category->slug) }}">
                                    &nbsp;{{ $category->name }}
                                </a>,&nbsp;
                            @endforeach
                        </div>
                    </div>
                    <div class="column">
                        <div class="meta-link"><i class="icon-clock"></i>
                            &nbsp;{{ format_date($item->published_at) }}
                        </div>
                    </div>
                </div>
                <div>
                    @if($featured_image)
                        <a class="post-thumb" href="{{ url($item->slug) }}"><img
                                    src="{{ $featured_image }}"
                                    alt="Post"></a>
                    @endif
                </div>
                <div>
                    {!! $item->rendered !!}
                </div>
            </div>
            @if(in_array($blog->template, ['right', 'left']))
                <div class="col-xl-3 col-lg-4  {{ $blog->template =='left' ? 'order-lg-1':'' }}">
                    @include('partials.blog_sidebar')
                </div>
            @endif
        </div>
    </div>
@endsection