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

    {!! Theme::css('css/bootstrap.css') !!}
    {!! Theme::css('css/theme.min.css') !!}

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script type="text/javascript">
        window.base_url = '{!! url('/') !!}';
    </script>

    {!! \Assets::css() !!}
    <style type="text/css">
        .nav-currency {
            padding-top: 2rem;
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

<div id="editable_content">
    @yield('editable_content')
</div>

@include('partials.footer')


{!! Theme::js('js/theme.min.js') !!}

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