@extends('layouts.master')

@section('editable_content')
    <div class="container padding-bottom-3x mb-1">
        <div class="row {{ !in_array($blog->template, ['right', 'left'])?'justify-content-center':'' }}">
            <div class="{{ !in_array($blog->template, ['right', 'left'])?'col-lg-10':'col-xl-9 col-lg-8' }} {{ $blog->template =='left' ? 'order-lg-2':'' }}">
                <!-- Post-->
                <div class="single-post-meta">
                    <div class="column">
                        <div class="meta-link pull-left badge badge-primary"><i
                                    class="fa fa-user-o"></i> {!! trans('corals-ecommerce-mimity::labels.post.show_author',['name' => $item->author->name])  !!}
                        </div>
                    </div>
                    <div class="column">
                        <div class="meta-link pull-right badge badge-info"><i class="fa fa-clock-o"></i>
                            &nbsp;{{ format_date($item->published_at) }}
                        </div>
                    </div>
                </div>
                <div>
                    @if($featured_image)
                        <a class="post-thumb" href="{{ url($item->slug) }}"><img
                                    src="{{ $featured_image }}"
                                    alt="Post" style="width: 100%"></a>
                    @endif
                </div>
                <div class="p-10">
                    @if(count($activeTags = $item->post->activeTags))
                        <div class="meta-link badge badge-success">
                            @foreach($activeTags as $tag)
                                <a href="{{ url('tag/'.$tag->slug) }}"><i class="fa fa-tag"></i>{{ $tag->name }}</a>,
                                &nbsp;
                            @endforeach
                        </div>
                    @endif
                    <div class="meta-link badge badge-light">
                        <span>@lang('corals-ecommerce-mimity::labels.post.category')</span>
                        @foreach($item->post->activeCategories as $category)
                            <a href="{{ url('category/'.$category->slug) }}">
                                &nbsp;<i class="fa fa-folder"></i>{{ $category->name }}
                            </a>,&nbsp;
                        @endforeach
                    </div>
                </div>
                <div>
                    {!! $item->rendered !!}
                </div>
            </div>

        </div>
    </div>
@endsection