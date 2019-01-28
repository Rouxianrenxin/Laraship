@isset($slider)
    <div class="owl-carousel owl-theme" id="{{ $slider->key }}">
        @if($slider->type == 'html')
            @forelse($slider->activeSlides as $slide)
                <div class="item">{!! $slide->content !!}</div>
            @empty
                <div class="item"><h4>{!! trans('Slider::labels.slider.item_empty') !!}</h4></div>
            @endforelse
        @endif

        @if($slider->type == 'images')
            @forelse($slider->activeSlides as $slide)
                <div class="item">
                    <img src="{!! asset($slide->content) !!}" alt="slide image">
                    @if(!empty($slide->description))
                        <div class="text-center">
                            {!! $slide->description !!}
                        </div>
                    @endif
                </div>
            @empty
                <img src="https://placehold.it/350x250&text=Empty..." alt="Empty...">
            @endforelse
        @endif

        @if($slider->type == 'videos')
            @forelse($slider->activeSlides as $slide)
                <div class="item-video">
                    <a class="owl-video" href="{!! asset($slide->content) !!}"></a>
                    @if(!empty($slide->description))
                        <div class="text-center">
                            {!! $slide->description !!}
                        </div>
                    @endif
                </div>
            @empty
                <img class="owl-lazy" data-src="https://placehold.it/350x250&text=Empty..." alt="Empty...">
            @endforelse
        @endif
    </div>
@section('js')
    @parent
    <script type="text/javascript">
        function initialized(event) {
            $(".owl-item").css("height", "{{ $slider->init_options['videoHeight']['number/boolean'] }}px");
            $(".item-video").css("height", "{{ $slider->init_options['videoHeight']['number/boolean'] }}px");
        }

        $(document).ready(function () {
            $owl = $('#{{ $slider->key }}').owlCarousel({
                onInitialized: initialized,
                rtl:@if(\Language::isRTL()){{'true'}}@else{{'false'}}@endif,
                @foreach($slider->init_options as $key=>$value)
                @if(current($value))
                @if(in_array(key ($value) ,  ['boolean','number','array','number/boolean']) || current($value) =="false" )
                {!!  $key.':'.current($value).',' !!}
                @else
                {!!  $key.":'".current($value)."'," !!}
                @endif
                @endif
                @endforeach
            });
        });
    </script>
@endsection
@else
    <p class="text-center text-danger">
        <strong> {!! trans('Slider::labels.slider.slider_cannot_found',['slider_key' => $slider_key]) !!}</strong></p>
@endisset()
