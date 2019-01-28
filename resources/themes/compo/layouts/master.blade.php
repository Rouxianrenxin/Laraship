<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">

<head>
    {!! \SEO::generate() !!}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ \Settings::get('site_favicon') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Bootstrap Framework Version 4.1.0 -->
    {!! Theme::css('css/bootstrap.min.css') !!}
    {!! Theme::css('font-awesome-4.7.0/css/font-awesome.min.css') !!}
    {!! Theme::css('css/vendors.min.css') !!}
    {!! Theme::css('css/style.min.css') !!}
    {!! Theme::css('css/nouislider.min.css') !!}

    {!! Theme::css('plugins/Ladda/ladda-themeless.min.css') !!}

    {!! \Html::style('assets/corals/plugins/lightbox2/css/lightbox.min.css') !!}
    {!! \Html::style('assets/corals/plugins/smartwizard/css/smart_wizard.css') !!}
    {!! \Html::style('assets/corals/plugins/smartwizard/css/smart_wizard_theme_arrows.css') !!}
    {!! \Html::style('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css') !!}

    {!! Theme::css('css/components.min.css') !!}
    {!! Theme::css('css/color-switch.css','color-switcher-style') !!}

    {!! Theme::css('css/custom.css') !!}
<!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif:400,400i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet">

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
</head>

<body>

<!-- Loader -->
<div class="loader-backdrop">
    <div class="loader">
        <div class="ball-1"></div>
        <div class="ball-2"></div>
    </div>
</div>

@include('partials.header')

<div id="editable_content">
    @yield('editable_content')
</div>
@include('partials.footer')

<div id="back"><i class="fa fa-angle-up"></i></div>

<div id="switch" class="">
    <a id="open-switch"><i class="fa fa-cog fa-spin"></i></a>
    <ul>
        <li id="combo1" class="style-option" data-style="Beige"></li>
        <li id="combo2" class="style-option" data-style="Blue"></li>
        <li id="combo3" class="style-option" data-style="Green"></li>
        <li id="combo4" class="style-option" data-style="Peach"></li>
        <li id="combo5" class="style-option" data-style="Red"></li>
        <li id="combo6" class="style-option" data-style="Yellow"></li>
    </ul>
</div>

{!! Theme::js('js/jquery.min.js') !!}
{!! Theme::js('js/popper.min.js') !!}

{!! Theme::js('js/nouislider.min.js') !!}

{!! \Html::script('assets/corals/plugins/lightbox2/js/lightbox.min.js') !!}
{!! \Html::script('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.js') !!}

{!! Theme::js('js/bootstrap.min.js') !!}

<!-- Ladda -->
{!! Theme::js('plugins/Ladda/spin.min.js') !!}
{!! Theme::js('plugins/Ladda/ladda.min.js') !!}

{!! Theme::js('js/owl.carousel.min.js') !!}

{!! Theme::js('js/main.js') !!}
{!! \Html::script('assets/corals/plugins/js.cookie.js') !!}
{!! Theme::js('js/color-switch.js') !!}


{!! Theme::js('js/compo_functions.js') !!}
{!! Theme::js('js/compo_main.js') !!}

{!! \Html::script('assets/corals/js/corals_functions.js') !!}
{!! \Html::script('assets/corals/js/corals_main.js') !!}

{!! Assets::js() !!}

@php  \Actions::do_action('footer_js') @endphp

@yield('js')

<script type="text/javascript">
    {!! \Settings::get('custom_js', '') !!}
</script>


@include('components.modal',['id'=>'global-modal'])


</html>