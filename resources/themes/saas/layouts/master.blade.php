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
    <!-- plugins -->
    {!! Theme::css('css/plugins/bundle.css') !!}
    {!! Theme::css('css/plugins/font-awesome/css/font-awesome.min.css') !!}
<!--main css file-->
    {!! Theme::css('css/style.css') !!}

    @if(\Language::isRTL())
        {!! Theme::css('css/plugins/bundle-rtl.css') !!}
        {!! Theme::css('css/style-rtl.css') !!}
    @endif

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        window.base_url = '{!! url('/') !!}';
    </script>

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
        <style type="text/css">
            .nav-currency {
                padding-top: 1.3rem;
            }

            @media (max-width: 991px) {
                .navbar-nav .nav-currency .nav-link {
                    display: inline;
                    margin-right: .3rem;
                }
            }
        </style>
    @endif
    <style type="text/css">
        {!! \Settings::get('custom_css', '') !!}
    </style>

</head>
<body>
<div id="preloader">
    <div id="preloader-inner"></div>
</div><!--/preloader-->
<!--back to top-->
<a href="#" class="scrollToTop"><i class="ion-ios-arrow-up"></i></a>
<!--back to top end-->


@include('partials.header')

<div id="editable_content">
    @yield('editable_content')
</div>

@include('partials.footer')

<!-- jQuery plugins-->
{!! Theme::js('js/plugins/plugins.js') !!}
{!! Theme::js('js/template-custom.js') !!}

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