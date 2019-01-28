@extends('layouts.master')

@section('editable_content')
    @include('partials.page_header')

    @php \Actions::do_action('pre_content',$item, $home??null) @endphp

    {!! $item->rendered !!}

    @isset($home)
        <!-- ******Latest blog Section****** -->
        <section id="latest-blog" class="latest-blog section">
            <div class="container">
                <h2 class="title text-center"> @lang('corals-neptune::labels.template.latest_posts')</h2>
                <div class="row">
                    @foreach(\CMS::getLatestPosts(4) as $post)
                        <div class="item col-md-6 col-12">
                            <div class="item-inner">
                                <figure class="figure">
                                    <a href="{{ url($post->slug) }}">
                                        <img class="img-fluid"
                                             src="{{ $post->featured_image }}"
                                             alt="{{ $post->title }}"/>
                                    </a>
                                </figure>
                                <div class="content-wrapper text-center">
                                    <h3 class="sub-title"><a href="{{ url($post->slug) }}">{{ $post->title }}</a></h3>
                                    <div class="desc">
                                        <p>
                                            {{ str_limit(strip_tags($post->rendered )) }}
                                        </p>
                                    </div><!--//desc-->
                                </div><!--//content-wrapper text-center-->
                            </div><!--//item-inner-->
                        </div><!--//item-->
                    @endforeach
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//latest-blog-->
    @endisset
@stop