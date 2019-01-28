<a href="{{ !empty($bannerSlug)?url('adverts/ads/'.$bannerSlug):'#' }}" target="_blank" class="clickable-object">
    <object width="{{ $banner->width }}" height="{{ $banner->height }}"
            data="{{ $banner->objectUrl }}">
    </object>
</a>