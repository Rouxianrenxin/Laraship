{!! Theme::css('css/bootstrap/dist/css/bootstrap.css') !!}
{!! Theme::css('css/metismenu/dist/metisMenu.css') !!}
{!! Theme::css('css/switchery-npm/index.css') !!}
{!! Theme::css('css/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') !!}
{!! Theme::css('css/font-awesome-4.7.0/css/font-awesome.min.css') !!}
{!! Theme::css('css/common/main.bundle.css') !!}
{!! Theme::css('css/layouts/vertical/core/main.css') !!}
{!! Theme::css('css/layouts/vertical/menu-type/compact.css') !!}
{!! Theme::css('css/layouts/vertical/themes/theme-a.css') !!}
{!! Theme::css('plugins/toast-master/css/jquery.toast.css') !!}
{!! Theme::css('plugins/select2/dist/css/select2.min.css') !!}
{!! Theme::css('plugins/sweetalert2/dist/sweetalert2.css') !!}
{!! Theme::css('css/common/custom.css') !!}
@if(\Language::getDirection() == 'rtl')
    {!! Theme::css('css/common/custom_rtl.css') !!}
@endif

<!-- Ladda  -->
{!! Theme::css('plugins/Ladda/ladda-themeless.min.css') !!}
{!! \Html::style('assets/corals/plugins/lightbox2/css/lightbox.min.css') !!}

{!! \Assets::css() !!}

@yield('css')

<script type="text/javascript">
    window.base_url = '{!! url('/') !!}';
</script>

{!! \Html::script('assets/corals/js/corals_header.js') !!}

@if(\Settings::get('google_analytics_id'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ \Settings::get('google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', "{{ \Settings::get('google_analytics_id') }}");
    </script>
@endif
