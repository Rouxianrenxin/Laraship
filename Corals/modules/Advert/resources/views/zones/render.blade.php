@isset($zone)
    <div style="padding:0; width: {{ $zone->width }}px;height: {{ $zone->height }}px; background-color: #f7f7f7;display: inline-block;">
        {!! \Advert::getRandomWeightedBanner($zone) !!}
    </div>
    <script>
        if (typeof embed !== 'undefined') {
            window.onload = function () {
                var embedChild = new embed.Child();
                embedChild.sendHeight();
            }
        }

    </script>
    @else
        <p class="text-center text-danger">
            <strong>
                Zone [{{ @$zone_key }}] Cannot be found
            </strong>
        </p>
        @endisset