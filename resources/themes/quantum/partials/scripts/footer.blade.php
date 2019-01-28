{!! Theme::js('js/jquery.min.js') !!}
{!! Theme::js('js/modernizr.custom.js') !!}
{!! Theme::js('js/bootstrap.bundle.min.js') !!}
{!! Theme::js('js/js.storage.js') !!}
{!! Theme::js('js/js.cookie.js') !!}
{!! Theme::js('js/pace.js') !!}
{!! Theme::js('js/metisMenu.js') !!}
{!! Theme::js('js/index.js') !!}
{!! Theme::js('js/jquery.mCustomScrollbar.concat.min.js') !!}
{!! Theme::js('js/app.js') !!}
{!! Theme::js('js/perfect-scrollbar.jquery.min.js') !!}

{!! Theme::js('plugins/toast-master/js/jquery.toast.js') !!}
{!! Theme::js('plugins/select2/dist/js/select2.full.min.js') !!}
{!! Theme::js('plugins/sweetalert2/dist/sweetalert2.min.js') !!}
{!! Theme::js('plugins/lodash/lodash.js') !!}
<!-- Ladda -->
{!! Theme::js('plugins/Ladda/spin.min.js') !!}
{!! Theme::js('plugins/Ladda/ladda.min.js') !!}

{!! Assets::js() !!}

{!! Theme::js('js/quantum_functions.js') !!}
{!! Theme::js('js/quantum_main.js') !!}

<!-- corals js -->
{!! \Html::script('assets/corals/plugins/lightbox2/js/lightbox.min.js') !!}
{!! \Html::script('assets/corals/plugins/clipboard/clipboard.min.js') !!}
{!! \Html::script('assets/corals/js/corals_functions.js') !!}
{!! \Html::script('assets/corals/js/corals_main.js') !!}

<!-- ================== GLOBAL APP SCRIPTS ==================-->
@include('Corals::corals_main')

@yield('js')

@php  \Actions::do_action('admin_footer_js') @endphp

@include('partials.notifications')
