<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">
<head>
    {!! \SEO::generate() !!}
    <title>@yield('title') | {{ \Settings::get('site_name', 'Corals') }}</title>

    @yield('css')
    @include('partials.scripts.header')
</head>

<body>

<div class="loader-wrap">
    <div class="pin"></div>

    <div class="pulse"></div>
</div>

@include('partials.header')


<div class="dashboard-list-box fl-wrap">
    <div class="dashboard-header fl-wrap">
    </div>
    @yield('before_content')

    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-md-6">
                @yield('custom-actions')
            </div>
            <div class="col-md-6 text-right" style="padding-bottom: 10px;">
                @yield('actions')
            </div>
        </div>
        <div class="row">
            <div class="content custom-form">
                <section id="sec1">
                    <div class="row">
                        <div class="col-md-2">
                            @include('partials.dashboard_sidebar')
                        </div>
                        <div class="col-md-10">
                            @yield('content')
                        </div>
                    </div>

                </section>
                <div class="limit-box fl-wrap"></div>
            </div>
        </div>

    </div>
</div>

<div>@include('partials.footer')</div>

<!-- Back To Top Button-->
<a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
<!-- Backdrop-->
<div class="site-backdrop"></div>

</div>

@include('partials.scripts.footer')

@include('components.modal',['id'=>'global-modal'])


</body>
</html>