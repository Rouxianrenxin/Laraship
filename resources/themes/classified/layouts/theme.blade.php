<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">
<head>
    {!! \SEO::generate() !!}
    @include('partials.scripts.header')
</head>

<body>

@include('partials.header')

<div id="editable_content">
    @yield('before_content')

    <div class="section-padding">
        @yield('editable_content')
    </div>

    @yield('after_content')

    @include('partials.footer')
</div>

@include('partials.scripts.footer')

@include('components.modal',['id'=>'global-modal'])

</body>
</html>