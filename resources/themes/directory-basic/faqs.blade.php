@extends('layouts.theme')

@section('editable_content')
    <div class="content">

        <section class="gray-section" id="sec1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {!! $faq->content !!}
                    </div>
                </div>
                <div class="row">
                    <div class="{{ !in_array($faq->template,  ['right', 'left'])?'col-lg-12':'col-md-8' }} {{ $faq->template =='left' ? 'order-lg-2':'' }}" style="margin: 0;">
                        <section class="gray-bg" id="sec4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion">
                                            @php $i = 1; @endphp
                                            @forelse($faqs as $faq)
                                                <a class="toggle @if($i == 1) act-accordion @else accordion @endif " href="#"> {{ $faq->title }}
                                                    @if(count($faq->categories))
                                                        @foreach($faq->categories as $category)
                                                            <span class="pull-right" style="margin-right: 20px; font-weight: bold;">
                                                                {{$category->name}}
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <div class="accordion-inner @if($i ==1) visible @endif">

                                                    <p>{!! $faq->content !!}</p>

                                                    @if(count($faq->tags))
                                                        <div class="post-opt">
                                                            <ul>
                                                                @foreach($faq->tags as $tag)
                                                                    <li><i class="fa fa-tags"></i> <a href="#">{{$tag->name}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            @php $i++; @endphp
                                            @empty
                                                <div class="alert alert-warning">
                                                    <h4>@lang('corals-directory-basic::labels.faqs.no_faqs_found')</h4>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </section>
    </div>
@stop