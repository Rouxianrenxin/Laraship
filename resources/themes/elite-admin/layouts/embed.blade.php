<html>
<head>
    {!! Theme::css('css/style.min.css') !!}
    {!! \Assets::css() !!}
    @yield('css')
</head>

<body>

@include($view, $view_variables)

{!! Theme::js('plugins/jquery/jquery-3.2.1.min.js') !!}

{!! Theme::js('plugins/bootstrap/dist/js/bootstrap.min.js') !!}

{!! Assets::js() !!}

@yield('js')

</body>
</html>