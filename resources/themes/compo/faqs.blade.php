@extends('layouts.master')

@section('editable_content')
    <section class="container mt-100 mb-100">
        <div id="faq" class="container text-center">
            <h2>{!! $faq->title !!}</h2>
            {!! $faq->content !!}
        </div>

        <div class="row">
            <div class="col-lg-12">
                @php $i = 1; @endphp
                @if(count($categories = \CMS::getCategoriesList(true, null, null, 'faq')))
                    @foreach($categories as $category)

                        <h2 class="heading">{{ $category->name }}</h2>
                        <div id="accordion-{{ $category->id }}" class="accordion-2" data-children=".item">
                            @if(count($faqs = $category->faqs()->published()->get()))
                                @php $j = 1; @endphp
                                @foreach($faqs as $faq)
                                    <div class="item">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" class="accordion-header {{ $j != 1 ? 'collapsed' : '' }}" data-parent="#accordion-{{ $category->id }}"
                                               href="#faq{{ $faq->id }}{{ $i }}" aria-expanded="{{ $j == 1 ? true : false }}" aria-controls="faq{{ $faq->id }}{{ $i }}">
                                                {{ $faq->title }}
                                                @if(count($faq->categories))
                                                    @foreach($faq->categories as $faq_category)
                                                        <span class="pull-right" style="margin-right: 20px; font-weight: bold;">
                                                            {{$faq_category->name}}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </a>
                                        </h5>
                                        <div id="faq{{ $faq->id }}{{ $i }}" class="collapse {{ $j == 1 ? 'show' : '' }}" role="tabpanel">
                                            <div class="accordion-body">
                                                <p class="mb-3">
                                                {!! $faq->content !!}
                                                </p>

                                                @if(count($faq->tags))
                                                    <ul class="list-inline mt-3">
                                                        @foreach($faq->tags as $tag)
                                                            <li class="list-inline-item"><i class="fa fa-tags"></i> <a href="#">{{$tag->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php $j++; @endphp
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    <h4>@lang('corals-compo::labels.faqs.no_faqs_found')</h4>
                                </div>
                            @endif
                        </div>
                        @php $i++; @endphp
                    @endforeach
                @else
                    <div class="alert alert-warning">
                        <h4>@lang('corals-compo::labels.faqs.no_faqs_found')</h4>
                    </div>
                @endif
                <div class="clearfix mt-80"></div>

            </div>
        </div>
    </section>

@endsection