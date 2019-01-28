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