<!DOCTYPE html>
<html lang="{{ \Language::getCode() }}" dir="{{ \Language::getDirection() }}">
<head>
    <title>
        @if($unreadNotifications = user()->unreadNotifications()->count())
            ({{ $unreadNotifications }})
        @endif
        @yield('title') | {{ \Settings::get('site_name', 'Corals') }}
    </title>

    <meta charset="utf-8">
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="shortcut icon" href="{{ \Settings::get('site_favicon') }}" type="image/png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

{!! Theme::css('font-awesome-4.7.0/css/font-awesome.min.css') !!}
{!! \Html::style('assets/corals/plugins/lightbox2/css/lightbox.min.css') !!}
{!! Theme::css('plugins/select2/dist/css/select2.min.css') !!}
{!! Theme::css('plugins/sweetalert2/dist/sweetalert2.css') !!}
{!! \Html::style('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css') !!}
{!! Theme::css('plugins/Ladda/ladda-themeless.min.css') !!}
<!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
{!! Theme::css('css/vendor.min.css') !!}
<!-- Main Template Styles-->
{!! Theme::css('css/styles.css') !!}

{!! \Html::script('assets/corals/js/corals_header.js') !!}

{!! Theme::css('css/custom.css') !!}
{!! Theme::css('css/custom_admin.css') !!}
<!-- Modernizr-->
    {!! Theme::js('js/modernizr.min.js') !!}

    <script type="text/javascript">
        window.base_url = '{!! url('/') !!}';
    </script>

    @yield('css')

    {!! \Assets::css() !!}

    @if(\Language::isRTL())
        {!! Theme::css('css/vendor-rtl.css') !!}
        {!! Theme::css('css/styles-rtl.css') !!}
    @endif

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
        {!! \Settings::get('custom_admin_css', '') !!}
    </style>
</head>

<body>

@include('partials.header')
<div class="offcanvas-wrapper">
    <div class="page-title" style="margin-bottom: 5px;">
        <div class="container">
            @yield('content_header')
        </div>
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
            @if(!(isset($hide_sidebar) && $hide_sidebar))
                <div class="col-md-3">
                    <nav class="list-group list-group-root well">
                        <a class="list-group-item {{ \Request::is('dashboard')?'active':'' }}"
                           href="{{ url('dashboard') }}">
                            @lang('corals-marketplace-master::labels.partial.dashboard')
                        </a>

                        @include('partials.menu.admin_menu_item', ['menus'=> \Menus::getMenu('sidebar','active') ])
                    </nav>
                </div>
            @endif
            <div class="{{ (isset($hide_sidebar) && $hide_sidebar)?'col-md-12':'col-md-9' }}">
                @yield('content')
            </div>
        </div>
    </div>

    <div>@include('partials.footer')</div>

    <!-- Back To Top Button-->
    <a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>

</div>

<!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
{!! Theme::js('js/vendor.min.js') !!}
{!! Theme::js('js/scripts.min.js') !!}
{!! \Html::script('assets/corals/plugins/lightbox2/js/lightbox.min.js') !!}
{!! \Html::script('https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.js') !!}

<!-- Ladda -->
{!! Theme::js('plugins/Ladda/spin.min.js') !!}
{!! Theme::js('plugins/Ladda/ladda.min.js') !!}
{!! Theme::js('plugins/select2/dist/js/select2.full.min.js') !!}
{!! Theme::js('plugins/sweetalert2/dist/sweetalert2.min.js') !!}
{!! Theme::js('js/functions.js') !!}
{!! Theme::js('js/main.js') !!}
{!! Theme::js('plugins/lodash/lodash.js') !!}

{!! \Html::script('assets/corals/js/corals_functions.js') !!}
{!! \Html::script('assets/corals/js/corals_main.js') !!}

{!! Assets::js() !!}

@php  \Actions::do_action('footer_js') @endphp

@include('Corals::corals_main')

@yield('js')

@php  \Actions::do_action('admin_footer_js') @endphp

<script type="text/javascript">
    {!! \Settings::get('custom_admin_js', '') !!}
</script>
<!-- /.row -->
<div class="modal fade modal-image" id="modal-image-crop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <strong>@lang('corals-marketplace-master::labels.auth.change_image')</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img width="100%" src="" id="image_cropper" alt="picture 1" class="img-responsive">
                </div>
                <div class="actions my-3">
                        <span class="">
                            @lang('corals-marketplace-master::labels.auth.browse_files')
                            <input type="file" class="custom-file" id="cropper" required>
                        </span>

                    <button type="button" class="btn btn-primary rotate" data-method="rotate"
                            data-option="-30">
                        <i class="fa fa-undo"></i></button>
                    <button type="button" class="btn btn-primary rotate" data-method="rotate"
                            data-option="30">
                        <i class="fa fa-repeat"></i></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary m-r-10 m-l-10"
                        id="Save">@lang('corals-marketplace-master::labels.auth.save',['title'=>''])</button>
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">@lang('corals-marketplace-master::labels.auth.close')</button>
            </div>
        </div>
    </div>
</div>
@include('components.modal',['id'=>'global-modal'])
@include('partials.notifications')

</body>
</html>
