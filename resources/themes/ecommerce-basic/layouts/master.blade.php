<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">
<head>
    {!! \SEO::generate() !!}
    <meta charset="utf-8">
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="shortcut icon" href="{{ \Settings::get('site_favicon') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! Theme::css('font-awesome-4.7.0/css/font-awesome.min.css') !!}
<!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    {!! Theme::css('css/vendor.min.css') !!}
<!-- Main Template Styles-->
    {!! Theme::css('css/styles.css') !!}


    {!! \Html::style('assets/corals/plugins/lightbox2/css/lightbox.min.css') !!}

    {!! \Html::style('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css') !!}
    {!! Theme::css('plugins/Ladda/ladda-themeless.min.css') !!}

    {!! Theme::css('css/custom.css') !!}
<!-- Modernizr-->
    {!! Theme::js('js/modernizr.min.js') !!}

    <script type="text/javascript">
        window.base_url = '{!! url('/') !!}';
    </script>

    @yield('css')

    {!! \Assets::css() !!}

    @if(\Language::isRTL())
        {!! Theme::css('css/vendor-rtl.css') !!}
        {!! Theme::css('css/styles-rtl.css') !!}
    @endif

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
</head>

<body>

@include('partials.header')

@yield('before_content')

<div id="editable_content">
    <!-- Off-Canvas Wrapper-->
    <div class="offcanvas-wrapper">
        @yield('editable_content')
        <div>@include('partials.footer')</div>
    </div>
</div>

<!-- Back To Top Button-->
<a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>
@yield('after_content')

<!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
{!! Theme::js('js/vendor.min.js') !!}
{!! Theme::js('js/scripts.min.js') !!}
{!! \Html::script('assets/corals/plugins/lightbox2/js/lightbox.min.js') !!}
{!! \Html::script('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.js') !!}

<!-- Ladda -->
{!! Theme::js('plugins/Ladda/spin.min.js') !!}
{!! Theme::js('plugins/Ladda/ladda.min.js') !!}

{!! Theme::js('js/functions.js') !!}
{!! Theme::js('js/main.js') !!}
{!! \Html::script('assets/corals/js/corals_functions.js') !!}
{!! \Html::script('assets/corals/js/corals_main.js') !!}

{!! Assets::js() !!}

@php  \Actions::do_action('footer_js') @endphp

@yield('js')

<script type="text/javascript">
    {!! \Settings::get('custom_js', '') !!}
</script>

@include('components.modal',['id'=>'global-modal'])

</body>
</html>