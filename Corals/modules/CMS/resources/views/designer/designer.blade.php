<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Designer | {{ \Settings::get('site_name', 'Corals') }}</title>
{!! Html::style('assets/corals/plugins/page-designer/css/toastr.min.css') !!}
{!! Html::style('assets/corals/plugins/page-designer/css/grapes.min.css') !!}
{!! Html::style('assets/corals/plugins/page-designer/css/tooltip.css') !!}
{!! Html::style('assets/corals/plugins/page-designer/css/grapesjs-preset-webpage.css') !!}
{!! Html::style('assets/corals/plugins/page-designer/css/perfect-scrollbar.css') !!}
{!! Html::style('assets/corals/plugins/page-designer/css/grapesjs-plugin-filestack.css') !!}
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        iframe {
            user-select: none;
            -webkit-user-select: none;
        }

        #toast-container {
            font-size: 13px;
            font-weight: lighter;
        }

        #toast-container > div,
        #toast-container > div:hover {
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
            font-family: Helvetica, sans-serif;
        }

        #toast-container > div {
            opacity: 0.95;
        }

        #gjs-pn-devices-c {
            width: 85%;
            z-index: 1;
        }

        #gjs-sm-float,
        #gjs-pn-views .fa-cog,
        #gjs-pn-commands .gjs-pn-buttons {
            display: none;
        }

        .gjs-pn-panel#gjs-pn-commands {
            width: 200px;
            box-shadow: none;
        }

        [data-tooltip]::after {
            background: rgba(51, 51, 51, 0.9);
        }

        .gjs-am-preview-cont {
            height: 100px;
            width: 100%;
        }

        .gjs-logo {
            height: 25px;
        }

        .gjs-logo-cont {
            position: absolute;
            left: 25px;
            top: 8px;
        }

        .gjs-logo-version {
            position: absolute;
            background-color: #756467;
            font-size: 10px;
            padding: 1px 7px;
            border-radius: 15px;
            bottom: 2px;
            right: -43px;
        }
    </style>

</head>
<body>

<div id="gjs">
    {!! $page->content !!}
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
{!! Html::script('assets/corals/plugins/page-designer/filestack.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/perfect-scrollbar.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/toastr.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapes.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-blocks-bootstrap4.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-plugin-filestack.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-blocks-basic.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-preset-webpage.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-plugin-forms.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-navbar.min.js') !!}
{!! Html::script('assets/corals/plugins/page-designer/grapesjs-component-countdown.min.js') !!}

<script type="text/javascript">
    var first_load = true;
    var editor = grapesjs.init({
        height: '100%',
        container: '#gjs',
        fromElement: true,
        showOffsets: 1,
        canvas: {
            styles: [
                @if($theme->css)
                        @foreach($theme->css as $css)
                    "{{ asset(Theme::url($css)) }}",
                @endforeach
                @endif
            ],
            scripts: [
                @if($theme->js)
                        @foreach($theme->js as $js)
                    "{{ asset(Theme::url($js)) }}",
                @endforeach
                @endif
            ],
        },
        commands: {
            defaults: [{
                id: 'save-page',
                run: function (editor, senderBtn) {
                    if (first_load) {
                        first_load = false;
                    } else {
                        var html = editor.getHtml();

                        var css = '<style type="css/text">' + editor.getCss() + '</style>';

                        var js = '<script type="text/javascript">' + editor.getJs() + '<\/script>';

                        var content = html + css + js;

                        $.ajax({
                            url: "{{ url('cms/pages/'.$page->hashed_id.'/save-design') }}",
                            type: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                'title': '{{ $page->title }}',
                                'slug': '{{ $page->slug }}',
                                'content': content
                            },
                            success: function (data) {
                                toastr.success(data['message']);
                            },
                            error: function (data) {
                                console.warn(data['message']);
                            }
                        });
                    }
                    senderBtn.set('active', false);
                },

                stop: function (editor, senderBtn) {
                },
            }]
        },
        plugins: ['grapesjs-blocks-bootstrap4'],
        pluginsOpts: {
            'grapesjs-blocks-bootstrap4': {

            }
        },

        storageManager: {
            type: 'none',
            storeComponents: 1,
            storeStyles: 1,
        },

        // Configure style
        styleManager: {
            sectors: [{
                name: 'General',
                buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom'],
                properties: [{
                    name: 'Alignment',
                    property: 'float',
                    type: 'radio',
                    defaults: 'none',
                    list: [
                        {value: 'none', className: 'fa fa-times'},
                        {value: 'left', className: 'fa fa-align-left'},
                        {value: 'right', className: 'fa fa-align-right'}
                    ],
                },
                    {property: 'position', type: 'select'}
                ],
            }, {
                name: 'Dimension',
                open: false,
                buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
                properties: [{
                    property: 'margin',
                    properties: [
                        {name: 'Top', property: 'margin-top'},
                        {name: 'Right', property: 'margin-right'},
                        {name: 'Bottom', property: 'margin-bottom'},
                        {name: 'Left', property: 'margin-left'}
                    ],
                }, {
                    property: 'padding',
                    properties: [
                        {name: 'Top', property: 'padding-top'},
                        {name: 'Right', property: 'padding-right'},
                        {name: 'Bottom', property: 'padding-bottom'},
                        {name: 'Left', property: 'padding-left'}
                    ],
                }],
            }, {
                name: 'Typography',
                open: false,
                buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-decoration', 'text-shadow'],
                properties: [
                    {name: 'Font', property: 'font-family'},
                    {name: 'Weight', property: 'font-weight'},
                    {name: 'Font color', property: 'color'},
                    {
                        property: 'text-align',
                        type: 'radio',
                        defaults: 'left',
                        list: [
                            {value: 'left', name: 'Left', className: 'fa fa-align-left'},
                            {value: 'center', name: 'Center', className: 'fa fa-align-center'},
                            {value: 'right', name: 'Right', className: 'fa fa-align-right'},
                            {value: 'justify', name: 'Justify', className: 'fa fa-align-justify'}
                        ],
                    }, {
                        property: 'text-decoration',
                        type: 'radio',
                        defaults: 'none',
                        list: [
                            {value: 'none', name: 'None', className: 'fa fa-times'},
                            {value: 'underline', name: 'underline', className: 'fa fa-underline'},
                            {value: 'line-through', name: 'Line-through', className: 'fa fa-strikethrough'}
                        ],
                    }, {
                        property: 'text-shadow',
                        properties: [
                            {name: 'X position', property: 'text-shadow-h'},
                            {name: 'Y position', property: 'text-shadow-v'},
                            {name: 'Blur', property: 'text-shadow-blur'},
                            {name: 'Color', property: 'text-shadow-color'}
                        ],
                    }],
            }, {
                name: 'Decorations',
                open: false,
                buildProps: ['opacity', 'background-color', 'border-radius', 'border', 'box-shadow', 'background'],
                properties: [{
                    type: 'slider',
                    property: 'opacity',
                    defaults: 1,
                    step: 0.01,
                    max: 1,
                    min: 0,
                }, {
                    property: 'border-radius',
                    properties: [
                        {name: 'Top', property: 'border-top-left-radius'},
                        {name: 'Right', property: 'border-top-right-radius'},
                        {name: 'Bottom', property: 'border-bottom-left-radius'},
                        {name: 'Left', property: 'border-bottom-right-radius'}
                    ],
                }, {
                    property: 'box-shadow',
                    properties: [
                        {name: 'X position', property: 'box-shadow-h'},
                        {name: 'Y position', property: 'box-shadow-v'},
                        {name: 'Blur', property: 'box-shadow-blur'},
                        {name: 'Spread', property: 'box-shadow-spread'},
                        {name: 'Color', property: 'box-shadow-color'},
                        {name: 'Shadow type', property: 'box-shadow-type'}
                    ],
                }, {
                    property: 'background',
                    properties: [
                        {name: 'Image', property: 'background-image'},
                        {name: 'Repeat', property: 'background-repeat'},
                        {name: 'Position', property: 'background-position'},
                        {name: 'Attachment', property: 'background-attachment'},
                        {name: 'Size', property: 'background-size'}
                    ],
                },],
            }, {
                name: 'Extra',
                open: false,
                buildProps: ['transition', 'perspective', 'transform'],
                properties: [{
                    property: 'transition',
                    properties: [
                        {name: 'Property', property: 'transition-property'},
                        {name: 'Duration', property: 'transition-duration'},
                        {name: 'Easing', property: 'transition-timing-function'}
                    ],
                }, {
                    property: 'transform',
                    properties: [
                        {name: 'Rotate X', property: 'transform-rotate-x'},
                        {name: 'Rotate Y', property: 'transform-rotate-y'},
                        {name: 'Rotate Z', property: 'transform-rotate-z'},
                        {name: 'Scale X', property: 'transform-scale-x'},
                        {name: 'Scale Y', property: 'transform-scale-y'},
                        {name: 'Scale Z', property: 'transform-scale-z'}
                    ],
                }]
            },
            ],
        },
    });
    // Simple warn notifier
    var origWarn = console.warn;
    toastr.options = {
        closeButton: true,
        preventDuplicates: true,
        showDuration: 250,
        hideDuration: 150
    };
    console.warn = function (msg) {
        if (msg.indexOf('[undefined]') == -1) {
            toastr.warning(msg);
        }
        origWarn(msg);
    };


    // Beautify tooltips
    var titles = document.querySelectorAll('*[title]');
    for (var i = 0; i < titles.length; i++) {
        var el = titles[i];
        var title = el.getAttribute('title');
        title = title ? title.trim() : '';
        if (!title)
            break;
        el.setAttribute('data-tooltip', title);
        el.setAttribute('title', '');
    }

    // Store and load events
    editor.on('storage:load', function (e) {
        console.log('Loaded ', e);
    });
    editor.on('storage:store', function (e) {
        console.log('Stored ', e);
    });

    editor.on('load', function () {
    });

    var panelManager = editor.Panels;

    panelManager.addPanel({
        id: 'corals-panel',
        visible: true,
        buttons: [
            {
                id: 'save-page',
                className: 'fa fa-floppy-o',
                command: 'save-page',
                attributes: {"data-tooltip": 'Save Page', "data-tooltip-pos": "bottom"},
                active: true
            }
        ]
    });

</script>
</body>
</html>