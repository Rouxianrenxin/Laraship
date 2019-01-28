@extends('layouts.theme')

@section('editable_content')
    @include('partials.page_header', ['item'=>$blog, 'content'=> (empty($blog->rendered)?('<h1>'.$blog->title.'</h1>'):$blog->rendered).(isset($title)?('<br/>'.$title):'')])
    <div class="content">
        <section class="gray-section" id="sec1">
            <div class="container">
                <div class="row">
                    <div class="{{ !in_array($blog->template,  ['right', 'left'])?'col-lg-12':'col-md-8' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                        @forelse($posts as $post)
                            <div class="list-single-main-wrapper fl-wrap" id="sec2">
                                <!-- article> -->
                                <article>
                                    <div class="list-single-main-media fl-wrap">
                                        <div class="single-slider-wrapper fl-wrap">
                                            @if($post->featured_image)
                                                <div class="">
                                                    <a href="{{ url($post->slug) }}">
                                                        <img src="{{$post->featured_image}}" alt="Post">
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="list-single-main-item fl-wrap">
                                        <div class="list-single-main-item-title fl-wrap">
                                            <h3><a href="{{url($post->slug)}}">{{$post->title}}</a>
                                            </h3>
                                        </div>
                                        <p>{{ str_limit(strip_tags($post->rendered ),250) }}</p>
                                        <div class="post-author"><a href="#">
                                                <img src="{{$post->author->picture_thumb}}" alt="">
                                                <span>{{ $post->author->name }}</span></a></div>
                                        <div class="post-opt">
                                            <ul>
                                                <li><i class="fa fa-calendar-check-o"></i>
                                                    <span>{{ format_date($post->published_at) }}</span>
                                                </li>
                                                <li><i class="fa fa-tags"></i>
                                                    @foreach($post->activeCategories as $category)
                                                        <a href="{{ url('category/'.$category->slug) }}">
                                                            &nbsp;{{ $category->name }}
                                                        </a>,
                                                    @endforeach</li>
                                            </ul>
                                        </div>
                                        <span class="fw-separator"></span>
                                        <div class="list-single-main-item-title fl-wrap">
                                            <h3>@lang('corals-directory-basic::labels.partial.tag_cloud') :</h3>
                                        </div>
                                        <div class="list-single-tags tags-stylwrap blog-tags">
                                            @foreach($post->activeTags as $postActiveTag)
                                                <a href="{{url('tag/'.$postActiveTag->slug)}}">{{$postActiveTag->name}}</a>
                                            @endforeach
                                        </div>
                                        <span class="fw-separator"></span>
                                        <a href='{{ url($post->slug) }}'
                                           class="btn transparent-btn float-btn">@lang('corals-directory-basic::labels.blog.read_more')
                                            <i
                                                    class="fa fa-eye"></i></a>
                                    </div>
                                </article>

                            {{ $posts->links('partials.paginator') }}
                            <!-- article end -->
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                <h4>@lang('corals-directory-basic::labels.blog.no_posts_found')</h4>
                            </div>
                        @endforelse
                    </div>
                    <!-- Pagination-->
                    <!--box-widget-wrap -->
                    @if(in_array($blog->template, ['right', 'left']))
                        <div class="col-md-4 {{ $blog->template =='left' ? 'order-lg-1':'' }}">
                            @include('partials.blog_sidebar')
                        </div>
                @endif
                <!--box-widget-wrap end -->
                </div>

            </div>

        </section>
    </div>
@stop