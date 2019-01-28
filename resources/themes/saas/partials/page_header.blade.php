@if(!isset($home))
    <div class="{{ isset($featured_image)?'':'page_header' }}">
        @if(isset($featured_image))
            <div class="dzsparallaxer auto-init" data-options='{direction: "reverse"}' style="height: 450px;">
                <div class="divimage dzsparallaxer--target "
                     style="width: 101%; height: 600px; background-image: url('{{ isset($featured_image)?$featured_image:Theme::url('images/bg2.jpg') }}')">
                </div>
                <div class=" parallax-text center-it page-title text-center">
                    <h1 class="text-uppercase">{!! isset($content)?$content:optional($item)->title  !!}</h1>
                </div>
            </div><!--end page header-->
            <div class="space-70"></div>
        @elseif(isset($content))
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="space-20"></div>
                        {!! $content !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif