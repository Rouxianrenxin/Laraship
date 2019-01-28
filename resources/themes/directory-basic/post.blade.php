@extends('layouts.theme')

@section('editable_content')
    @include('partials.page_header',['title'=>$item->title,'featured_image'=>null])

    <section class="gray-section" id="sec1">
        <div class="container">
            <div class="row {{ !in_array($blog->template, ['right', 'left'])?'justify-content-center':'' }}">
                <div class="{{ !in_array($blog->template,  ['right', 'left'])?'col-lg-10':'col-md-8 col-lg-8' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                    <div class="list-single-main-wrapper fl-wrap" id="sec2">
                        <!-- article> -->
                        <article>
                            <div class="list-single-main-media fl-wrap">
                                <div class="single-slider-wrapper fl-wrap">
                                    <div class="single-slider fl-wrap">
                                        <div class="slick-slide-item">
                                            @if($featured_image)
                                                <a href="{{url($item->slug)}}">
                                                    <img src="{{$featured_image}}" alt="">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-single-main-item fl-wrap">
                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>{{$item->title}}</h3>
                                </div>
                                <p>
                                    {!! $item->rendered !!}
                                </p>
                                <div class="post-author"><a href="#"><img src="{{$item->post->author->picture_thumb}}" alt=""><span>By , Alisa Noory</span></a>
                                </div>
                                <div class="post-opt">
                                    <ul>
                                        <li><i class="fa fa-calendar-check-o"></i>
                                            <span>{{format_date($item->published_at)}}</span></li>
                                        <li><i class="fa fa-eye"></i> <span>264</span></li>
                                        <li><i class="fa fa-tags"></i>
                                            @foreach($item->post->activeCategories as $category)
                                                <a href="{{ url('category/'.$category->slug) }}">
                                                    &nbsp;{{ $category->name }}
                                                </a>,&nbsp;
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                                <span class="fw-separator"></span>

                                <div class="list-single-main-item-title fl-wrap">
                                    <h3>@lang('corals-directory-basic::labels.partial.tag_cloud') :</h3>
                                </div>
                                <div class="list-single-tags tags-stylwrap blog-tags">
                                    @if(count($activeTags = $item->post->activeTags))
                                        <div class="meta-link">
                                            @foreach($activeTags as $tag)
                                                <a href="{{ url('tag/'.$tag->slug) }}">{{ $tag->name }}</a>,&nbsp;
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </article>
                        <!-- article end -->
                    </div>
                </div>
                <!--box-widget-wrap -->
                @if(in_array($blog->template, ['right', 'left']))
                    <div class="col-md-4 col-lg-4  {{ $blog->template =='left' ? 'order-lg-1':'' }}">
                        @include('partials.blog_sidebar')
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection