<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if($unreadNotifications = user()->unreadNotifications()->count())
            ({{ $unreadNotifications }})
        @endif
        @yield('title') | {{ \Settings::get('site_name', 'Corals') }}
    </title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ \Settings::get('site_favicon') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ================== GOOGLE FONTS ==================-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
    @include('partials.scripts.header')

    <style type="text/css">
        {!! \Settings::get('custom_admin_css', '') !!}
    </style>
</head>
<body class="compact-menu">
<div id="app">
    @include('partials.sidebar')
    <div class="content-wrapper">
        <!-- TOP TOOLBAR WRAPPER -->
        @include('partials.header')
        <div class="content">
            <header class="page-header">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        @yield('content_header')
                    </div>
                    <div class="align-self-center text-right m-b-10">
                        @yield('custom-actions')
                        @yield('actions')
                    </div>
                </div>
            </header>
            <section class="page-content container-fluid">
                @yield('content')
            </section>
        </div>
    </div>
</div>
@include('partials.footer')

@include('components.modal',['id'=>'global-modal'])

@include('partials.scripts.footer')

<script type="text/javascript">
    {!! \Settings::get('custom_admin_js', '') !!}
</script>
</body>
</html>
