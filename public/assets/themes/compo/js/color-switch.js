function clearActiveStyle() {
    $(".compo-theme-style").remove();
}

function activateStyle(style) {
    clearActiveStyle();
    $('<link rel="stylesheet" class="compo-theme-style" type="text/css" href="/assets/themes/compo/css/color-options/' + style + '/components.css">').insertAfter("#color-switcher-style");
    $('<link rel="stylesheet" class="compo-theme-style" type="text/css" href="/assets/themes/compo/css/color-options/' + style + '/style.css">').insertAfter("#color-switcher-style");
    Cookies.set('active-style', style);
}

let activeStyle = Cookies.get('active-style');

if (activeStyle) {
    activateStyle(activeStyle)
}

$(window).on('load', function () {
    $('#open-switch').click(function () {
        $("#switch").toggleClass("open-switch");
    });

    stylePath = "css/style.css";
    componentsPath = "css/components.css";

    $(".style-option").click(function () {
        activateStyle($(this).data('style'));
    });
});