@if(!isset($home) || !$home)
    <div class="{{ isset($featured_image)?'':'page_header' }}">
        @if(isset($featured_image))
            <section class="promo section" style="background: #65758e url({{ $featured_image }}) no-repeat 50% top;
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                    min-height: 400px;">
                <div class="container text-center">
                    <h2 class="title">{{ $item->title }}</h2>
                </div><!--//container-->
            </section><!--//promo-->
        @elseif(isset($content))
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {!! $content !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif