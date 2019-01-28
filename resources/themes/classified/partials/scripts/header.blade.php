<meta charset="utf-8">
<!-- Mobile Specific Meta Tag-->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link rel="shortcut icon" href="{{ \Settings::get('site_favicon') }}" type="image/png">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

{!! Theme::css('css/bootstrap.min.css') !!}
<!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
{!! Theme::css('fonts/line-icons.css') !!}

{!! Theme::css('font-awesome-4.7.0/css/font-awesome.min.css') !!}

<!-- Main Template Styles-->
{!! Theme::css('css/slicknav.css') !!}

{!! Theme::css('css/nivo-lightbox.css') !!}

{!! \Html::style('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css') !!}

{!! Theme::css('plugins/select2/dist/css/select2.min.css') !!}

{!! Theme::css('plugins/Lightbox/css/lightbox.min.css') !!}

{!! Theme::css('css/animate.css') !!}

{!! Theme::css('css/owl.carousel.css') !!}

{!! Theme::css('css/main.css') !!}

{!! Theme::css('css/responsive.css') !!}

{!! Theme::css('plugins/Ladda/ladda-themeless.min.css') !!}

<!-- toastr -->
{!! Theme::css('plugins/toastr/toastr.min.css') !!}
<!-- sweetalert2 -->
{!! Theme::css('plugins/sweetalert2/dist/sweetalert2.css') !!}


{!! Theme::css('plugins/noUISlider/css/nouislider.min.css') !!}

{!! Theme::css('css/custom.css') !!}

<script type="text/javascript">
    window.base_url = '{!! url('/') !!}';
</script>

@yield('css')

{!! \Assets::css() !!}

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
<style type="text/css">
    {!! \Settings::get('custom_css', '') !!}
</style>