<!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
{{--{!! Theme::js('js/infobox.min.js') !!}--}}
{!! Theme::js('js/jquery.min.js') !!}
{!! Theme::js('js/bootstrap.min.js') !!}

{!! Theme::js('js/plugins.js') !!}
{!! Theme::js('js/scripts.js') !!}


{!! \Html::script('https://maps.googleapis.com/maps/api/js?key='.\Settings::get('utility_google_address_api_key','').'&libraries=places') !!}

{!! Theme::js('js/map_infobox.js') !!}
{!! Theme::js('js/markerclusterer.js') !!}

{!! Theme::js('js/maps.js') !!}

{!! \Html::script('assets/corals/plugins/lightbox2/js/lightbox.min.js') !!}
{!! \Html::script('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.js') !!}

{!! Theme::js('plugins/toastr/toastr.min.js') !!}

{!! Theme::js('plugins/Lightbox/js/lightbox.js') !!}


{!! Theme::js('js/directory_functions.js') !!}
{!! Theme::js('js/directory_main.js') !!}

{!! Theme::js('plugins/Ladda/spin.min.js') !!}
{!! Theme::js('plugins/Ladda/ladda.min.js') !!}


{!! Theme::js('plugins/select2/dist/js/select2.full.js') !!}

<!-- Jquery BlockUI -->
{!! Theme::js('plugins/jquery-block-ui/jquery.blockUI.min.js') !!}

{!! Theme::js('plugins/sweetalert2/dist/sweetalert2.all.min.js') !!}

{!! \Html::script('assets/corals/plugins/clipboard/clipboard.min.js') !!}
{!! \Html::script('assets/corals/js/corals_functions.js') !!}
{!! \Html::script('assets/corals/js/corals_main.js') !!}

{!! Assets::js() !!}

@php  \Actions::do_action('footer_js') @endphp

@include('partials.notifications')
@include('Corals::corals_main')
@yield('js')

<script type="text/javascript">
    {!! \Settings::get('custom_js', '') !!}
</script>
