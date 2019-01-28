<!-- Go to Top Link -->
<a href="#" class="back-to-top">
    <i class="lni-chevron-up"></i>
</a>

<!-- Preloader -->
<div id="preloader">
    <div class="loader" id="loader-1"></div>
</div>
<!-- End Preloader -->

<!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
{!! Theme::js('js/jquery-min.js') !!}

{!! Theme::js('js/popper.min.js') !!}

{!! Theme::js('js/bootstrap.min.js') !!}

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

{!! Theme::js('plugins/Lightbox/js/lightbox.js') !!}

{!! \Html::script('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.js') !!}

{!! Theme::js('plugins/select2/dist/js/select2.full.min.js') !!}

{!! Theme::js('js/jquery.counterup.min.js') !!}

{!! Theme::js('js/waypoints.min.js') !!}

{!! Theme::js('js/wow.js') !!}

{!! Theme::js('js/owl.carousel.min.js') !!}

{!! Theme::js('js/nivo-lightbox.js') !!}

{!! Theme::js('js/jquery.slicknav.js') !!}

{!! Theme::js('js/summernote.js') !!}

{!! Theme::js('js/main.js') !!}

<!-- toastr -->
{!! Theme::js('plugins/toastr/toastr.min.js') !!}

{!! Theme::js('plugins/noUISlider/js/nouislider.min.js') !!}

{!! Theme::js('plugins/sweetalert2/dist/sweetalert2.all.min.js') !!}

{!! Theme::js('js/classified_functions.js') !!}

{!! Theme::js('js/classified_main.js') !!}

{!! Theme::js('plugins/Ladda/spin.min.js') !!}

{!! Theme::js('plugins/Ladda/ladda.min.js') !!}

{!! \Html::script('assets/corals/js/corals_functions.js') !!}

{!! \Html::script('assets/corals/js/corals_main.js') !!}


{!! Assets::js() !!}

@php  \Actions::do_action('footer_js') @endphp
@include('Corals::corals_main')


@yield('js')

<script type="text/javascript">
    {!! \Settings::get('custom_js', '') !!}
</script>

@include('partials.notifications')