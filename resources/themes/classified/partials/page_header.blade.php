<!-- Page Header Start -->
<div class="page-header"
     style="{{ isset($featured_image)?'background: url('. $featured_image .');':'background-color:#000;' }}color:#fff;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-wrapper">
                    @if(isset($content))
                        {!! $content !!}
                    @elseif(isset($item))
                        <h2 class="product-title">{{$item->title}}</h2>
                    @elseif(isset($title))
                        <h2 class="product-title">{{$title}}</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->