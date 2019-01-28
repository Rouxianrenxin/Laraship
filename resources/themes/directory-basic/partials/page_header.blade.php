<section class="parallax-section" data-scrollax-parent="true">
    <div class="bg par-elem "
         data-bg="{{ isset($item) ? (\CMS::getContentFeaturedImage($item)??\Theme::url('/images/bg/header-bg.jpg')):\Theme::url('/images/bg/header-bg.jpg')  }}"
         data-scrollax="properties: { translateY: '30%' }"></div>
    <div class="overlay"></div>
    <div class="container">
        <div class="section-title center-align">
            <h2><span>{!! $item->title  !!}</span></h2>
        </div>
    </div>
    <div class="header-sec-link">
        <div class="container"><a href="#sec1"
                                  class="custom-scroll-link">@lang('corals-directory-basic::labels.dashboard.lets_start')</a>
        </div>
    </div>
</section>
@if(!isset($home) || !$home)
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                @if(isset($featured_image))
                    <img src="{{ $featured_image }}" alt="{{ $item->title }}" width="100%"
                         style="max-height: 400px;"/>
                @elseif(isset($content))
                    {!! $content !!}
                @else
                    <h1>{!! optional($item)->title  !!}</h1>
                @endif
            </div>
        </div>
    </div>
@endif