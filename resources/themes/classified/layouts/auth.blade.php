<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">
<head>
    <title>@yield('title') | {{ \Settings::get('site_name', 'Corals') }}</title>

    @include('partials.scripts.header')
</head>

<body>

@include('partials.header')

<div>
    @yield('before_content')

    <div class="section-padding">
        <div class="container">
            @yield('content')
        </div>
    </div>

    @yield('after_content')

    @include('partials.footer')
</div>

@include('partials.scripts.footer')
@include('components.modal',['id'=>'global-modal'])


@php \Actions::do_action('admin_footer_js') @endphp

</body>
</html>