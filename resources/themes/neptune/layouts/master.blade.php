<!DOCTYPE html>
<html>
<head>
    {!! \SEO::generate() !!}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ \Settings::get('site_favicon') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='https://fonts.googleapis.com/css?family=Merriweather+Sans:700,300italic,400italic,700italic,300,400'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Russo+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>

    {!! Theme::css('plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! Theme::css('plugins/font-awesome/css/font-awesome.css') !!}
    {!! Theme::css('plugins/elegant_font/css/style.css') !!}
    {!! Theme::css('css/styles.css') !!}

    <script type="text/javascript">
        window.base_url = '{!! url('/') !!}';
    </script>

    {!! \Assets::css() !!}

    @yield('css')
    <style type="text/css">
        .nav-currency {
            padding-top: .8rem;
        }

        @media (max-width: 991px) {
            .navbar-nav .nav-currency .nav-link {
                display: inline;
                margin-right: .3rem;
            }
        }
    </style>

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

<div id="editable_content" style="margin-top: 49px;">
    @yield('editable_content')
</div>

@include('partials.footer')


{!! Theme::js('plugins/jquery-3.2.1.min.js') !!}
{!! Theme::js('plugins/popper.min.js') !!}
{!! Theme::js('plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Theme::js('plugins/back-to-top.js') !!}
{!! Theme::js('plugins/jquery-match-height/jquery.matchHeight-min.js') !!}
{!! Theme::js('js/functions.js') !!}
{!! Theme::js('js/main.js') !!}
{!! Theme::js('plugins/isMobile/isMobile.min.js') !!}
{!! Theme::js('js/form-mobile-fix.js') !!}
{!! Theme::js('plugins/imagesloaded.pkgd.min.js') !!}
{!! Theme::js('plugins/isotope.pkgd.min.js') !!}
{!! Theme::js('js/isotope-custom.js') !!}

{!! \Html::script('assets/corals/js/corals_functions.js') !!}
{!! \Html::script('assets/corals/js/corals_main.js') !!}

{!! Assets::js() !!}


@php  \Actions::do_action('footer_js') @endphp

<script type="text/javascript">
    {!! \Settings::get('custom_js', '') !!}
</script>

@yield('js')

<script type="text/javascript">
    {!! \Settings::get('custom_js', '') !!}
</script>

@include('components.modal',['id'=>'global-modal'])


</body>
</html>