@if(!isset($home))
    <div class="row">
        <div class="col-md-12">
            <div class="m-b-30 text-center">
                @if(isset($featured_image))
                    <img src="{{ $featured_image }}" title="{{ isset($item)?optional($item)->title:'' }}"
                         style="max-width: 100%;max-height: 500px;"
                         alt="{{ isset($item)?optional($item)->title:'' }}"/>
                @elseif(isset($content) && !empty($content))
                    {!! $content !!}
                @else
                    <h2>{!! isset($item)?optional($item)->title:'' !!}</h2>
                @endif
            </div>
        </div>
    </div>
@endif