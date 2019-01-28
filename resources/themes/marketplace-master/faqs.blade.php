@extends('layouts.public')

@section('editable_content')
    @include('partials.page_header', ['item'=>$faq])

    <div class="container padding-bottom-3x mb-1">
        <div class="row mb-5">
            <div class="col-md-12">
                {!! $faq->content !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(count($categories = \CMS::getCategoriesList(true, null, null, 'faq')))
                    <div class="row">
                        <!-- Side Menu-->
                        <div class="col-lg-3 col-md-4">
                            <ul class="list-group nav nav-tabs" role="tablist">
                                @foreach($categories as $category)
                                    <li class="nav-item">
                                        <a class="list-group-item {{$loop->first ? 'active' : ''}}"
                                           href="#{{ $category->slug }}" data-toggle="tab" role="tab">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Content-->
                        <div class=" col-lg-9 col-md-8">
                            <div class="tab-content p-0">
                                @php $i = 1; @endphp
                                @foreach($categories as $category)
                                    <div class="tab-pane fade  {{$loop->first ? 'show active' : ''}}"
                                         id="{{ $category->slug }}" role="tabpanel">
                                        <div class="accordion" id="accordion{{ $category->id }}" role="tablist">
                                            @if(count($faqs = $category->faqs()->published()->get()))

                                                @foreach($faqs as $faq)

                                                    <div class="card">
                                                        <div class="card-header" role="tab">
                                                            <h6>
                                                                <a class="collapsed" href="#collapse{{ $faq->id }}{{ $i }}" data-toggle="collapse"
                                                                   data-parent="#accordion{{ $category->id }}">
                                                                    {{ $faq->title }}

                                                                    @if(count($faq->categories))
                                                                        @foreach($faq->categories as $faq_category)
                                                                            <span class="pull-right" style="margin-right: 20px; font-weight: bold;">
                                                                                    {{$faq_category->name}}
                                                                                </span>
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            </h6>
                                                        </div>
                                                        <div class="collapse" id="collapse{{ $faq->id }}{{ $i }}" data-parent="#accordion{{ $category->id }}" role="tabpanel">
                                                            <div class="card-body">
                                                                <p>{!! $faq->content !!}</p>
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
                                                @endforeach
                                            @else
                                                <div class="alert alert-warning">
                                                    <h4>@lang('corals-marketplace-master::labels.faqs.no_faqs_found')</h4>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <h4>@lang('corals-marketplace-master::labels.faqs.no_faqs_found')</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection