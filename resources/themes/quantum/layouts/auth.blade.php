<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ \Settings::get('site_name', 'Corals') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ \Settings::get('site_favicon') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.scripts.header')
    @yield('css')
</head>

<body class="compact-menu">

@yield('content')
@include('partials.scripts.footer')

@yield('js')

@component('components.modal',[
        'id'=>'terms',
        'header'=>trans('corals-quantum-admin::labels.auth.terms_modal_header',['siteName'=>\Settings::get('site_name')])
    ])
    {!! \Settings::get('terms_and_policy') !!}
@endcomponent

</body>
</html>
